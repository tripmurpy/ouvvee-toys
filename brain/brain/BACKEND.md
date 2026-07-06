# BACKEND.md - Ouvvee Toys

Dokumen ini adalah kontrak teknis backend untuk Ouvvee Toys. Fokusnya adalah Laravel backend yang aman, transaction-safe, dan hanya mengirim data yang sudah disaring ke frontend.

## 1. Goals

- Menyediakan backend untuk katalog publik, checkout login, status pesanan, wishlist, review, dan admin dashboard read-only.
- Menjaga seluruh aturan bisnis di server, bukan di frontend.
- Mencegah data penting bocor ke frontend: credential, cost rule, secret, stack trace, dan data internal lain.
- Menjamin checkout, pembayaran simulasi, pengiriman, dan pengurangan stok berjalan konsisten dalam transaksi database.
- Menghasilkan response yang stabil, kecil, dan mudah dipakai Blade maupun JSON client.

## 2. Scope Path

Backend dibangun sebagai Laravel web app dengan API tipis bila dibutuhkan untuk interaksi async. Path implementasi yang paling aman:

| Phase | Fokus | Output |
| --- | --- | --- |
| 0 | Foundation | Auth, env, logging, storage, base layout, middleware, error handling |
| 1 | Discovery | Public catalog, product detail, category browse, search |
| 2 | Cart and wishlist | Add/update/remove cart item, wishlist toggle, empty state |
| 3 | Checkout | Address, payment method, shipping method, shipping cost, order create |
| 4 | Order lifecycle | Order status, payment simulation, shipment state, review guard |
| 5 | Admin monitoring | Read-only dashboard, stock summary, sales summary, low stock list |
| 6 | Hardening | Cache, queue jobs, throttling, audit logs, test coverage |

## 3. Requirements

### Functional

| Area | Requirement |
| --- | --- |
| Public catalog | User can read active products, categories, gallery, price, stock, age, size, weight, and safety note. |
| Auth | User must login for checkout, wishlist, review, and order history. |
| Cart | One active cart per buyer, quantity updates, item remove, subtotal calculation. |
| Checkout | Address ownership check, payment method check, shipping method check, stock check, and order creation. |
| Order | Order code, order summary, payment status, shipment status, and order detail pages. |
| Review | Only buyers who have purchased the product can review it. |
| Admin | Read-only monitoring of sales, stock, low-stock products, and recent orders. |

### Non-functional

| Area | Requirement |
| --- | --- |
| Security | Server-side validation, authz, CSRF, hidden secrets, sanitized serialization. |
| Reliability | Checkout and stock deduction must be atomic. |
| Performance | Cache catalog, reference data, and dashboard aggregates. |
| Observability | Structured logs with request id and business context. |
| Maintainability | Keep route, validation, and business logic separated. |
| Data safety | Never expose raw DB schema, internal cost rules, or env values to frontend. |

## 4. Tech Stack

| Layer | Choice | Notes |
| --- | --- | --- |
| App | Laravel 11+ | Blade-first web app, not SPA-first. |
| Runtime | PHP 8.3+ | Use current stable PHP in the project environment. |
| Database | MySQL 8.x | Relational model from `schema.sql`. |
| Auth | Laravel starter kit | Session auth, CSRF protection, password hashing. |
| Queue | Database or Redis | `database` is fine for local dev; Redis if available in prod. |
| Cache | Redis preferred, file fallback | Cache catalog and reference data. |
| Storage | Local public disk | Product images and approved media only. |
| Logging | Laravel daily logs | Add request id and business context. |

No new dependency is required for the MVP. Use built-in Laravel auth, validation, cache, queue, and policy tools first.

## 5. Backend Boundary

Frontend must never receive:

- `APP_KEY`, DB credentials, mail credentials, queue credentials, or storage secrets.
- raw `password`, `remember_token`, or other sensitive user fields.
- shipping rate formula internals, supplier cost, or operational cost data.
- stack traces, SQL errors, debug dumps, or internal class names.
- private storage paths or unapproved file system paths.

Frontend should only receive sanitized view data or API resources:

- `slug`, `name`, `price`, `stock`, `rating`, `category`, `age`, `main_image_url`, `gallery`.
- `order_code`, `order_status`, `payment_status`, `shipment_status`, `subtotal`, `shipping_cost`, `total_price`.
- admin aggregates only, never raw hidden operational data.

## 6. Route Model

Primary surface is `routes/web.php`. JSON routes in `routes/api.php` are secondary and only needed for async usage or future mobile clients.

### Public web routes

| Method | Path | Middleware | Purpose |
| --- | --- | --- | --- |
| GET | `/` | public | Home page, featured products, entry to catalog. |
| GET | `/products` | public | Catalog, search, pagination, category filter. |
| GET | `/products/{product:slug}` | public | Product detail page. |
| GET | `/categories/{category:slug}` | public | Category browse page. |

### Auth routes

| Method | Path | Middleware | Purpose |
| --- | --- | --- | --- |
| GET/POST | `/login` | `guest` / `throttle` | Login. |
| GET/POST | `/register` | `guest` / `throttle` | Register. |
| POST | `/logout` | `auth` + CSRF | Logout. |

### Customer action routes

| Method | Path | Middleware | Purpose |
| --- | --- | --- | --- |
| GET | `/cart` | `auth` | Cart page. |
| GET | `/wishlist` | `auth` | Wishlist page. |
| GET | `/checkout` | `auth` | Checkout form. |
| GET | `/orders` | `auth` | Order history page. |
| GET | `/orders/{order:order_code}` | `auth` + ownership | Customer order status page. |
| POST | `/cart/items` | `auth` | Add product to cart. |
| PATCH | `/cart/items/{cartItem}` | `auth` + ownership | Update quantity. |
| DELETE | `/cart/items/{cartItem}` | `auth` + ownership | Remove item. |
| POST | `/checkout` | `auth` + `throttle` | Create order from cart. |
| POST | `/products/{product:slug}/reviews` | `auth` + purchased-product check | Create review. |
| POST | `/wishlist/{product:slug}` | `auth` | Add to wishlist. |
| DELETE | `/wishlist/{product:slug}` | `auth` | Remove from wishlist. |

### Admin routes

| Method | Path | Middleware | Purpose |
| --- | --- | --- | --- |
| GET | `/admin` | `auth` + `can:access-admin` | Read-only dashboard. |
| GET | `/admin/orders` | `auth` + `can:access-admin` | Recent orders list. |
| GET | `/admin/orders/{order:order_code}` | `auth` + `can:access-admin` | Order detail. |
| GET | `/admin/inventory` | `auth` + `can:access-admin` | Stock summary and low stock list. |
| GET | `/admin/reports/sales` | `auth` + `can:access-admin` | Sales summary. |
| POST | `/admin/orders/{order:order_code}/payments/simulate` | `auth` + `can:access-admin` + local/staging only | Internal payment simulation only, not for frontend. |

### Optional API routes

If async JSON is needed, expose a thin `api/v1` surface with the same authorization rules.

| Method | Path | Purpose |
| --- | --- | --- |
| GET | `/api/v1/products` | Public catalog payload. |
| GET | `/api/v1/products/{product:slug}` | Product detail payload. |
| POST | `/api/v1/cart/items` | Add to cart. |
| PATCH | `/api/v1/cart/items/{cartItem}` | Update cart quantity. |
| DELETE | `/api/v1/cart/items/{cartItem}` | Remove cart item. |
| POST | `/api/v1/checkout` | Create order. |
| GET | `/api/v1/orders/{order:order_code}` | Order detail. |
| POST | `/api/v1/wishlist/toggle` | Toggle wishlist state. |
| POST | `/api/v1/reviews` | Create review. |
| GET | `/api/v1/admin/dashboard` | Admin aggregates only. |

## 7. Auth and Authorization

Use built-in Laravel session auth, not a separate auth microservice.

Rules:

- `guest` for login/register.
- `auth` for cart, checkout, wishlist, review, order history.
- `can:access-admin` or a gate/policy for admin-only routes.
- Ownership checks for cart items, orders, addresses, and reviews.
- CSRF required for all `web` POST/PATCH/DELETE actions.
- Throttle login, register, checkout, and payment simulation.

Do not add a role package unless a real need appears. Built-in gates and policies are enough for this scope.

## 8. Validation

Use `FormRequest` classes per action. Keep validation server-side even if frontend also validates.

| Action | Core rules |
| --- | --- |
| Register | `name` required max 100, `email` required email unique, `password` required min 8 confirmed. |
| Login | `email` required email, `password` required. |
| Add to cart | `product_id` exists active product, `quantity` integer min 1. |
| Update cart | `quantity` integer min 1 max available stock. |
| Checkout | `address_id` exists and belongs to user, `payment_method_id` exists, `shipping_method_id` exists. |
| Shipping calc | `shipping_method_id` exists, total weight positive, rate bracket must exist. |
| Review | `rating` integer 1 to 5, `comment` string max 1000, product must belong to a completed purchase. |
| Wishlist | product must exist and be active. |
| Search | `q` string max 100, trim whitespace. |

Validation failure should return:

- HTML form: redirect back with errors and old input.
- JSON: `422` with field details.

## 9. Business Logic

### Product and catalog

- Only `active` products are public.
- Product detail loads gallery from `product_images`.
- Product route key should be `slug`, not raw database id.
- Price shown on product cards is public price only, not internal cost.

### Cart

- One active cart per user.
- Duplicate add should merge quantity, not create a second line.
- Cart subtotal is always derived from current product price unless checkout snapshot is being built.
- Quantity cannot exceed available stock.

### Checkout

Order creation must be transactional.

Flow:

1. Validate auth, cart, address ownership, payment method, and shipping method.
2. Read cart items and lock the relevant product rows.
3. Recheck stock in the same transaction.
4. Compute subtotal from current product price.
5. Compute shipping from `shipping_rates` using total weight and chosen method.
6. Create `orders` row with snapshot values.
7. Create `order_items` rows with snapshot price per item.
8. Create `payments` and `shipments` rows.
9. Decrement stock.
10. Mark cart as checked out and clear active items.
11. Commit.

If any step fails, rollback everything.

### Payment simulation

- Canonical statuses should be `pending`, `paid`, and `failed`.
- If current SQL enum still uses `unpaid`, map `pending` to `unpaid` at the persistence layer or migrate the enum.
- Payment simulation should not call a real gateway.
- Failure should set order state consistently and release stock if the order must be cancelled.

### Shipment

- Shipment methods are limited to the scope in database docs.
- Shipment status should be server-controlled.
- Do not expose internal rate formulas to frontend.

### Review

- User can review only if they purchased the product.
- One review per `user + product + order`.
- Review should be blocked for cancelled orders and should prefer completed or delivered orders.

### Wishlist

- Add/remove should be idempotent.
- Duplicate add should not create duplicate rows.

### Admin dashboard

- Read-only aggregate data only.
- No product CRUD in this scope.
- Low stock threshold should be configurable, not hardcoded in views.

## 10. Database

Use `brain/brain/database-design.md` and `brain/brain/schema.sql` as the source of truth for the MVP. Backend-specific rules:

- `products.slug` should exist as a unique public route key.
- `categories.slug` should exist as a unique public route key.
- `orders.order_code` must be unique and opaque enough for public use.
- `order_items.price_each` and `orders.total_price` are snapshots and must not be recalculated from current product price.
- `payments.id_order` and `shipments.id_order` remain one-to-one.
- `wishlists` stays composite-keyed by `id_user + id_product`.
- `reviews` uniqueness should prevent duplicate reviews for the same purchase.
- Use `status` columns instead of hard deletes for public catalog records.

### Required indexes

| Table | Index |
| --- | --- |
| `categories` | `(slug)` unique |
| `products` | `(id_category, status)`, `(slug)` unique |
| `cart_items` | `(id_cart, id_product)` unique |
| `orders` | `(id_user, order_date)`, `(order_status)` |
| `order_items` | `(id_order, id_product)` unique |
| `reviews` | `(id_product, created_at)` |
| `shipping_rates` | `(id_shipping_method, min_weight_gram, max_weight_gram)` |
| `wishlists` | primary key already covers it |

### Query rules

- Never load cart/order/product data with N+1 queries.
- Eager load relations used on product detail, order detail, and admin dashboard.
- Keep transactional reads inside the same database transaction when stock is involved.

## 11. Response Contract

### HTML response rules

- Successful form submit: redirect to next page or back with flash message.
- Validation error: redirect back with field errors.
- Auth error: redirect to login or show 401/403 page depending context.
- Not found: 404 page, no stack trace in production.

### JSON response rules

Use a small envelope:

```json
{
  "data": {},
  "meta": {
    "request_id": "req_01J..."
  }
}
```

Error envelope:

```json
{
  "error": {
    "code": "OUT_OF_STOCK",
    "message": "Stok tidak mencukupi",
    "fields": {
      "quantity": ["Max 2"]
    }
  },
  "meta": {
    "request_id": "req_01J..."
  }
}
```

### HTTP status map

| Code | Use |
| --- | --- |
| 200 | Read success |
| 201 | Create success |
| 204 | Delete success |
| 400 | Bad request |
| 401 | Not authenticated |
| 403 | Forbidden |
| 404 | Not found |
| 409 | State conflict, stock race, duplicate purchase edge |
| 422 | Validation failed |
| 429 | Throttled |
| 500 | Unhandled server error |

## 12. Environment Variables

Document and keep these in `.env`:

| Group | Variables |
| --- | --- |
| App | `APP_NAME`, `APP_ENV`, `APP_KEY`, `APP_DEBUG`, `APP_URL`, `APP_TIMEZONE`, `APP_LOCALE`, `APP_FALLBACK_LOCALE`, `APP_FAKER_LOCALE` |
| Database | `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` |
| Session and cache | `SESSION_DRIVER`, `SESSION_LIFETIME`, `CACHE_STORE` |
| Queue | `QUEUE_CONNECTION` |
| Storage | `FILESYSTEM_DISK` |
| Mail | `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME` |
| Logging | `LOG_CHANNEL`, `LOG_STACK`, `LOG_LEVEL` |
| Optional Redis | `REDIS_HOST`, `REDIS_PASSWORD`, `REDIS_PORT` |
| App rules | `LOW_STOCK_THRESHOLD`, `ORDER_CODE_PREFIX`, `SHIPPING_ORIGIN_POSTAL_CODE`, `INVOICE_RETENTION_DAYS` |

Rules:

- Never expose `.env` values to frontend.
- Use config files to read env once, not inline in controllers.
- Keep app-specific business thresholds in env or config, not in Blade.

## 13. File Storage

### Public storage

- Product images and approved media go to the public disk.
- Frontend gets URLs only, not filesystem paths.
- Store files with hashed or generated names, not user-provided names.

### Private storage

- Internal exports, logs, or admin-only artifacts should stay private.
- If order receipts or invoices are generated, protect them with auth or signed URLs.

### Media rules

- `product_images` is the source for gallery data.
- 3D model files are optional and must not be required for checkout.
- Do not expose raw upload temp paths or storage driver details.

## 14. Caching

Cache data that changes slowly or is expensive to aggregate.

| Data | Suggested cache |
| --- | --- |
| Product catalog | 5 to 15 minutes |
| Category list | 15 to 60 minutes |
| Payment methods | Long TTL or forever until changed |
| Shipping methods and rates | Long TTL with invalidation on edit |
| Home featured products | 5 to 15 minutes |
| Admin dashboard aggregates | 1 to 5 minutes |

Rules:

- Invalidate product cache when price, stock, status, or gallery changes.
- Invalidate dashboard cache after checkout, payment change, or shipment update.
- Redis is preferred for tags; file cache is acceptable for local dev.

## 15. Background Jobs

Use jobs or scheduled tasks for work that should not block the request.

| Job | Purpose |
| --- | --- |
| SendOrderConfirmation | Notify buyer after successful order create or payment state change. |
| ExpireUnpaidOrders | Cancel stale unpaid orders and restore stock. |
| SendLowStockAlert | Notify admin when stock crosses the threshold. |
| WarmCatalogCache | Prime catalog and category cache after content changes. |
| GenerateSalesDigest | Build periodic sales summary if needed. |

Rules:

- Queue jobs must be idempotent.
- Failed jobs must log enough context to retry safely.
- Use `database` queue in local dev if Redis is not available.

## 16. Logging and Traceability

- Use daily log files in production.
- Add `request_id` or correlation id to every request log and JSON meta.
- Log business context: `user_id`, `order_code`, `product_id`, `action`, `status`.
- Redact passwords, tokens, payment secrets, and stack traces from normal logs.
- Keep a separate audit trail if admin reads or order state changes need tracing.

## 17. Localization and Copy

- Default locale should be Indonesian (`id`) unless the project decides otherwise.
- Use Laravel translation strings for validation, flash text, and common errors.
- Public product copy can be bilingual later, but MVP should stay consistent and simple.

## 18. Definition of Done

Backend is done when:

- Public users can browse products without login.
- Anonymous users cannot checkout.
- Stock never goes negative.
- Order creation is transactional and snapshots prices.
- Order, payment, and shipment states are server-controlled.
- Review is blocked unless the buyer actually purchased the product.
- Admin dashboard is read-only.
- Frontend receives only sanitized fields and no secrets.
- Logs are usable for tracing one request from checkout to order.

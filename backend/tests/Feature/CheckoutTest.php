<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ShippingMethod;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_creates_order_and_decrements_stock(): void
    {
        $this->seed();

        $user = $this->createUser('buyer@ouvvee.test');
        $product = $this->createProduct();
        $stock = $product->stock;

        $this->actingAs($user)
            ->post(route('cart.items.store'), [
                'id_product' => $product->id_product,
                'quantity' => 1,
            ])
            ->assertRedirect(route('cart.index'));

        $this->actingAs($user)
            ->get(route('checkout.index'))
            ->assertOk()
            ->assertSee('images/products/mechanical-arm-display-figure.png', false);

        $this->actingAs($user)
            ->post(route('checkout.store'), [
                'recipient_name' => 'Benny',
                'phone' => '081234567890',
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta',
                'district' => 'Kebayoran Baru',
                'detail_address' => 'Jl. Mainan No. 7',
                'postal_code' => '12110',
                'id_payment_method' => PaymentMethod::firstOrFail()->id_payment_method,
                'id_shipping_method' => ShippingMethod::firstOrFail()->id_shipping_method,
            ])
            ->assertRedirect();

        $this->assertSame($stock - 1, $product->refresh()->stock);
        $this->assertTrue(Cart::where('id_user', $user->id_user)->where('status', 'checked_out')->exists());
        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseCount('order_items', 1);

        $this->actingAs($user)
            ->get(route('orders.show', $user->orders()->firstOrFail()))
            ->assertOk()
            ->assertSee('images/products/mechanical-arm-display-figure.png', false);
    }

    public function test_cart_merge_respects_stock_limit(): void
    {
        $this->seed();

        $user = $this->createUser('buyer@ouvvee.test');
        $product = $this->createProduct(['stock' => 2]);

        $this->actingAs($user)->post(route('cart.items.store'), [
            'id_product' => $product->id_product,
            'quantity' => 1,
        ])->assertRedirect(route('cart.index'));

        $this->actingAs($user)->post(route('cart.items.store'), [
            'id_product' => $product->id_product,
            'quantity' => 1,
        ])->assertRedirect(route('cart.index'));

        $this->assertSame(2, CartItem::firstOrFail()->quantity);

        $this->actingAs($user)->post(route('cart.items.store'), [
            'id_product' => $product->id_product,
            'quantity' => 1,
        ])->assertSessionHas('error');

        $this->assertSame(2, CartItem::firstOrFail()->quantity);
    }

    public function test_buy_now_redirects_to_checkout_after_adding_item(): void
    {
        $this->seed();

        $user = $this->createUser('buyer@ouvvee.test');
        $product = $this->createProduct();

        $this->actingAs($user)->post(route('cart.items.store'), [
            'id_product' => $product->id_product,
            'quantity' => 1,
            'redirect_to' => 'checkout',
        ])->assertRedirect(route('checkout.index'));

        $this->assertDatabaseHas('cart_items', [
            'id_product' => $product->id_product,
            'quantity' => 1,
        ]);
    }

    public function test_checkout_does_not_create_order_when_stock_is_insufficient(): void
    {
        $this->seed();

        $user = $this->createUser('buyer@ouvvee.test');
        $product = $this->createProduct(['stock' => 1]);

        $this->actingAs($user)->post(route('cart.items.store'), [
            'id_product' => $product->id_product,
            'quantity' => 1,
        ]);

        $product->update(['stock' => 0]);

        $this->actingAs($user)
            ->post(route('checkout.store'), $this->checkoutPayload())
            ->assertSessionHas('error');

        $this->assertDatabaseCount('orders', 0);
        $this->assertSame(0, $product->refresh()->stock);
    }

    public function test_users_cannot_access_another_users_cart_item_or_order(): void
    {
        $this->seed();

        $owner = $this->createUser('owner@ouvvee.test');
        $other = $this->createUser('other@ouvvee.test');
        $product = $this->createProduct();

        $this->actingAs($owner)->post(route('cart.items.store'), [
            'id_product' => $product->id_product,
            'quantity' => 1,
        ]);

        $cartItem = CartItem::firstOrFail();

        $this->actingAs($other)
            ->patch(route('cart.items.update', $cartItem), ['quantity' => 1])
            ->assertForbidden();

        $this->actingAs($owner)
            ->post(route('checkout.store'), $this->checkoutPayload())
            ->assertRedirect();

        $order = $owner->orders()->firstOrFail();

        $this->actingAs($other)
            ->get(route('orders.show', $order))
            ->assertForbidden();
    }

    private function createUser(string $email): User
    {
        return User::create([
            'name' => 'Benny Buyer',
            'email' => $email,
            'password' => 'password',
            'phone' => '081234567890',
            'role' => User::ROLE_BUYER,
        ]);
    }

    private function checkoutPayload(): array
    {
        return [
            'recipient_name' => 'Benny',
            'phone' => '081234567890',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta',
            'district' => 'Kebayoran Baru',
            'detail_address' => 'Jl. Mainan No. 7',
            'postal_code' => '12110',
            'id_payment_method' => PaymentMethod::firstOrFail()->id_payment_method,
            'id_shipping_method' => ShippingMethod::firstOrFail()->id_shipping_method,
        ];
    }

    private function createProduct(array $overrides = []): Product
    {
        $category = Category::create([
            'category_name' => 'Construction',
            'slug' => 'construction',
            'description' => 'Figure display bertema alat berat dan industrial.',
        ]);

        $product = Product::create(array_merge([
            'id_category' => $category->id_category,
            'slug' => 'test-mechanical-arm-display-figure',
            'product_name' => 'Test Mechanical Arm Display Figure',
            'price' => 1195000,
            'description' => 'Figure lengan mekanik dengan base display, cocok untuk koleksi dan pajangan.',
            'image_url' => '/images/products/mechanical-arm-display-figure.png',
            'model_url' => null,
            'stock' => 15,
            'recommended_age' => '12+',
            'safety_note' => 'Tidak untuk anak di bawah 3 tahun karena memiliki bagian kecil.',
            'size' => '14 x 12 x 16 cm',
            'weight_gram' => 300,
            'status' => Product::STATUS_ACTIVE,
        ], $overrides));

        ProductImage::create([
            'id_product' => $product->id_product,
            'image_url' => '/images/products/mechanical-arm-display-figure.png',
            'alt_text' => 'Mechanical Arm Display Figure',
            'is_primary' => true,
        ]);

        return $product;
    }
}

<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ShippingMethod;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewAndAdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_review_is_blocked_without_purchase(): void
    {
        $this->seed();

        $user = User::create([
            'name' => 'Benny Buyer',
            'email' => 'buyer@ouvvee.test',
            'password' => 'password',
            'phone' => '081234567890',
            'role' => 'buyer',
        ]);
        $product = $this->createProduct();

        $this->actingAs($user)->get(route('reviews.create', $product))->assertForbidden();
    }

    public function test_admin_dashboard_requires_admin_role(): void
    {
        $this->seed();

        $buyer = User::create([
            'name' => 'Benny Buyer',
            'email' => 'buyer@ouvvee.test',
            'password' => 'password',
            'phone' => '081234567890',
            'role' => 'buyer',
        ]);
        $admin = User::where('email', 'admin@ouvvee.test')->firstOrFail();

        $this->actingAs($buyer)->get(route('admin.dashboard'))->assertForbidden();
        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
    }

    public function test_admin_sales_total_counts_paid_orders_only(): void
    {
        $this->seed();

        $buyer = User::create([
            'name' => 'Benny Buyer',
            'email' => 'buyer@ouvvee.test',
            'password' => 'password',
            'phone' => '081234567890',
            'role' => 'buyer',
        ]);
        $admin = User::where('email', 'admin@ouvvee.test')->firstOrFail();
        $product = $this->createProduct();

        $this->actingAs($buyer)->post(route('cart.items.store'), [
            'id_product' => $product->id_product,
            'quantity' => 1,
        ]);

        $this->actingAs($buyer)->post(route('checkout.store'), [
            'recipient_name' => 'Benny',
            'phone' => '081234567890',
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta',
            'district' => 'Kebayoran Baru',
            'detail_address' => 'Jl. Mainan No. 7',
            'postal_code' => '12110',
            'id_payment_method' => PaymentMethod::firstOrFail()->id_payment_method,
            'id_shipping_method' => ShippingMethod::firstOrFail()->id_shipping_method,
        ]);

        $order = $buyer->orders()->firstOrFail();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertViewHas('salesTotal', '0');

        $this->actingAs($buyer)->post(route('orders.pay', $order));

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertViewHas('salesTotal', (string) $order->total_price);
    }

    private function createProduct(): Product
    {
        $category = Category::create([
            'category_name' => 'Construction',
            'slug' => 'construction',
            'description' => 'Figure display bertema alat berat dan industrial.',
        ]);

        return Product::create([
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
            'status' => 'active',
        ]);
    }
}

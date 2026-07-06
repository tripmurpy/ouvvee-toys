<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\PaymentMethod;
use App\Models\Product;
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

        $user = User::where('email', 'buyer@ouvvee.test')->firstOrFail();
        $product = Product::where('stock', '>', 0)->firstOrFail();
        $stock = $product->stock;

        $this->actingAs($user)
            ->post(route('cart.items.store'), [
                'id_product' => $product->id_product,
                'quantity' => 1,
            ])
            ->assertRedirect(route('cart.index'));

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
    }
}

<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_catalog_and_detail_render_active_products(): void
    {
        $this->seed();

        $product = Product::active()->firstOrFail();

        $this->get('/products')->assertOk()->assertSee($product->product_name);
        $this->get(route('products.show', $product))->assertOk()->assertSee($product->product_name);
    }
}

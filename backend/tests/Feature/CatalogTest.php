<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_catalog_and_detail_render_active_products(): void
    {
        $this->seed();

        $product = $this->createProduct();
        $featured = Product::active()->latest('id_product')->firstOrFail();
        $thumbnailPath = ltrim((string) $product->image_url, '/');

        $this->assertNotSame('', $thumbnailPath);
        $this->assertFileExists(public_path($thumbnailPath));
        $this->assertTrue(
            ProductImage::query()
                ->where('id_product', $product->id_product)
                ->where('is_primary', true)
                ->exists()
        );

        $this->get('/')->assertOk()->assertSee($featured->product_name);
        $this->get('/products')->assertOk()->assertSee($product->product_name);
        $this->get(route('products.show', $product))->assertOk()->assertSee($product->product_name);
    }

    public function test_category_browse_renders_active_products(): void
    {
        $this->seed();

        $product = $this->createProduct();
        $inactive = $this->createProduct([
            'slug' => 'inactive-display-figure',
            'product_name' => 'Inactive Display Figure',
            'status' => Product::STATUS_INACTIVE,
        ]);

        $this->get(route('categories.show', $product->category))
            ->assertOk()
            ->assertSee($product->product_name)
            ->assertDontSee($inactive->product_name);
    }

    private function createProduct(array $overrides = []): Product
    {
        $category = Category::firstOrCreate([
            'slug' => 'construction',
        ], [
            'category_name' => 'Construction',
            'description' => 'Figure display bertema alat berat dan industrial.',
        ]);

        $product = Product::create(array_merge([
            'id_category' => $category->id_category,
            'slug' => 'mechanical-arm-display-figure',
            'product_name' => 'Mechanical Arm Display Figure',
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

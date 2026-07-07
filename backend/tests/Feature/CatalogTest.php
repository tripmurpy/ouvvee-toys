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
        $this->get('/products')
            ->assertOk()
            ->assertSee($product->product_name)
            ->assertSee('Putar model 3D, baca detail pentingnya, lalu pilih figure yang paling pas.')
            ->assertSee('Buka keranjang')
            ->assertSee('Preview 3D aktif pada produk yang mendukung model GLB.')
            ->assertSee('Model 3D Test Mechanical Arm Display Figure', false)
            ->assertSee('environment-image="neutral"', false)
            ->assertSee('exposure="1.65"', false)
            ->assertDontSee('Cari cepat')
            ->assertDontSee('Urutkan');
        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee($product->product_name)
            ->assertSee('Kembali')
            ->assertSee($product->category->category_name)
            ->assertSee('Preview 3D aktif')
            ->assertSee('environment-image="neutral"', false)
            ->assertSee('exposure="1.65"', false)
            ->assertSee('Pilih jumlah lalu lanjut beli')
            ->assertSee('Subtotal')
            ->assertSee('Beli Langsung');
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

    public function test_homepage_featured_collection_uses_nine_products(): void
    {
        $this->seed();

        foreach (range(1, 10) as $index) {
            $this->createProduct([
                'slug' => "display-figure-{$index}",
                'product_name' => "Display Figure {$index}",
            ]);
        }

        $this->get('/')
            ->assertOk()
            ->assertViewHas('featured', fn ($featured) => $featured->count() === 9)
            ->assertSee('gallery-product-marquee')
            ->assertSee('gallery-product-track');
    }

    public function test_product_display_image_falls_back_to_public_catalog_art(): void
    {
        $product = $this->createProduct([
            'slug' => 'dragonborn-display-figure',
            'product_name' => 'Dragonborn Display Figure',
            'image_url' => null,
        ]);

        $this->assertSame('images/products/red-dragon-head-figure.png', $product->displayImagePath());
    }

    public function test_product_display_model_falls_back_to_public_3d_asset(): void
    {
        $product = $this->createProduct([
            'slug' => 'bulldozer-track-figure',
            'product_name' => 'Bulldozer Track Figure',
            'model_url' => null,
        ]);

        $this->assertSame('models/products/bulldozer.glb', $product->displayModelPath());
    }

    public function test_catalog_api_returns_live_product_fields(): void
    {
        $this->seed();

        $product = $this->createProduct();

        $this->getJson('/api/products')
            ->assertOk()
            ->assertJsonPath('data.0.slug', $product->slug)
            ->assertJsonPath('data.0.name', $product->product_name)
            ->assertJsonPath('data.0.stock', $product->stock)
            ->assertJsonPath('data.0.category', $product->category->category_name)
            ->assertJsonPath('meta.total', 1)
            ->assertJsonMissingPath('data.0.id');
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

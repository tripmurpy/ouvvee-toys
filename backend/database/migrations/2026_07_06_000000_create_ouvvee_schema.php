<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table): void {
            $table->id('id_user');
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->string('phone', 20)->nullable();
            $table->enum('role', ['buyer', 'admin'])->default('buyer');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('addresses', function (Blueprint $table): void {
            $table->id('id_address');
            $table->foreignId('id_user')->constrained('users', 'id_user')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('recipient_name', 100);
            $table->string('phone', 20);
            $table->string('province', 100);
            $table->string('city', 100);
            $table->string('district', 100);
            $table->text('detail_address');
            $table->string('postal_code', 10)->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table): void {
            $table->id('id_category');
            $table->string('category_name', 100)->unique();
            $table->string('slug', 120)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table): void {
            $table->id('id_product');
            $table->foreignId('id_category')->constrained('categories', 'id_category')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('slug', 170)->unique();
            $table->string('product_name', 150);
            $table->decimal('price', 12, 2);
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->string('model_url')->nullable();
            $table->integer('stock')->default(0);
            $table->string('recommended_age', 50)->nullable();
            $table->text('safety_note')->nullable();
            $table->string('size', 50)->nullable();
            $table->integer('weight_gram');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->index(['id_category', 'status']);
        });

        Schema::create('product_images', function (Blueprint $table): void {
            $table->id('id_image');
            $table->foreignId('id_product')->constrained('products', 'id_product')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('image_url');
            $table->string('alt_text', 150)->nullable();
            $table->boolean('is_primary')->default(false);
            $table->unique(['id_product', 'image_url']);
        });

        Schema::create('carts', function (Blueprint $table): void {
            $table->id('id_cart');
            $table->foreignId('id_user')->constrained('users', 'id_user')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('status', ['active', 'checked_out'])->default('active');
            $table->timestamp('created_at')->nullable();
            $table->index(['id_user', 'status']);
        });

        Schema::create('cart_items', function (Blueprint $table): void {
            $table->id('id_cart_item');
            $table->foreignId('id_cart')->constrained('carts', 'id_cart')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_product')->constrained('products', 'id_product')->restrictOnDelete()->cascadeOnUpdate();
            $table->integer('quantity');
            $table->unique(['id_cart', 'id_product']);
        });

        Schema::create('payment_methods', function (Blueprint $table): void {
            $table->id('id_payment_method');
            $table->string('method_name', 50)->unique();
            $table->text('description')->nullable();
        });

        Schema::create('shipping_methods', function (Blueprint $table): void {
            $table->id('id_shipping_method');
            $table->string('method_name', 50)->unique();
            $table->text('description')->nullable();
        });

        Schema::create('shipping_rates', function (Blueprint $table): void {
            $table->id('id_shipping_rate');
            $table->foreignId('id_shipping_method')->constrained('shipping_methods', 'id_shipping_method')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('min_weight_gram');
            $table->integer('max_weight_gram');
            $table->decimal('base_cost', 12, 2);
            $table->decimal('cost_per_kg', 12, 2);
            $table->unique(['id_shipping_method', 'min_weight_gram', 'max_weight_gram']);
        });

        Schema::create('orders', function (Blueprint $table): void {
            $table->id('id_order');
            $table->foreignId('id_user')->constrained('users', 'id_user')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_address')->constrained('addresses', 'id_address')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('order_code', 50)->unique();
            $table->dateTime('order_date');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('shipping_cost', 12, 2);
            $table->decimal('total_price', 12, 2);
            $table->enum('order_status', ['waiting_payment', 'paid', 'processing', 'shipped', 'completed', 'cancelled'])->default('waiting_payment');
            $table->index(['id_user', 'order_date']);
            $table->index('order_status');
        });

        Schema::create('order_items', function (Blueprint $table): void {
            $table->id('id_order_item');
            $table->foreignId('id_order')->constrained('orders', 'id_order')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_product')->constrained('products', 'id_product')->restrictOnDelete()->cascadeOnUpdate();
            $table->integer('quantity');
            $table->decimal('price_each', 12, 2);
            $table->decimal('total_price', 12, 2);
            $table->unique(['id_order', 'id_product']);
        });

        Schema::create('payments', function (Blueprint $table): void {
            $table->id('id_payment');
            $table->foreignId('id_order')->unique()->constrained('orders', 'id_order')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_payment_method')->constrained('payment_methods', 'id_payment_method')->restrictOnDelete()->cascadeOnUpdate();
            $table->enum('payment_status', ['unpaid', 'paid', 'failed'])->default('unpaid');
            $table->dateTime('paid_at')->nullable();
        });

        Schema::create('shipments', function (Blueprint $table): void {
            $table->id('id_shipment');
            $table->foreignId('id_order')->unique()->constrained('orders', 'id_order')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_shipping_method')->constrained('shipping_methods', 'id_shipping_method')->restrictOnDelete()->cascadeOnUpdate();
            $table->decimal('shipping_cost', 12, 2);
            $table->string('tracking_number', 100)->nullable();
            $table->enum('shipment_status', ['not_shipped', 'on_delivery', 'delivered'])->default('not_shipped');
        });

        Schema::create('reviews', function (Blueprint $table): void {
            $table->id('id_review');
            $table->foreignId('id_user')->constrained('users', 'id_user')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_product')->constrained('products', 'id_product')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_order')->constrained('orders', 'id_order')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->unique(['id_user', 'id_product', 'id_order']);
            $table->index(['id_product', 'created_at']);
        });

        Schema::create('wishlists', function (Blueprint $table): void {
            $table->foreignId('id_user')->constrained('users', 'id_user')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('id_product')->constrained('products', 'id_product')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->primary(['id_user', 'id_product']);
        });
    }

    public function down(): void
    {
        foreach ([
            'wishlists',
            'reviews',
            'shipments',
            'payments',
            'order_items',
            'orders',
            'shipping_rates',
            'shipping_methods',
            'payment_methods',
            'cart_items',
            'carts',
            'product_images',
            'products',
            'categories',
            'addresses',
            'users',
        ] as $table) {
            Schema::dropIfExists($table);
        }
    }
};

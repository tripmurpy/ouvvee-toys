<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ShippingMethod;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@ouvvee.test'],
            ['name' => 'Ouvvee Admin', 'password' => 'password', 'role' => 'admin']
        );
        User::firstOrCreate(
            ['email' => 'buyer@ouvvee.test'],
            ['name' => 'Benny Buyer', 'password' => 'password', 'role' => 'buyer', 'phone' => '081234567890']
        );

        $categories = collect([
            ['category_name' => 'Mecha', 'slug' => 'mecha'],
            ['category_name' => 'Construction', 'slug' => 'construction'],
            ['category_name' => 'Drone', 'slug' => 'drone'],
            ['category_name' => 'Mythos', 'slug' => 'mythos'],
            ['category_name' => 'Vehicle', 'slug' => 'vehicle'],
        ])->mapWithKeys(fn ($data) => [$data['slug'] => Category::firstOrCreate(['slug' => $data['slug']], $data)]);

        foreach ([
            ['Ruin Sentinel Type-Zero', 'mecha', 249000, 12, '8+', 480, '/models/products/robot_police.glb'],
            ['Ashen Builder Unit', 'construction', 189000, 6, '5+', 620, '/models/products/bulldozer.glb'],
            ['Crimson Crab Drone', 'drone', 229000, 9, '8+', 390, '/models/products/robot_crab.glb'],
            ['Excavator Relic Mk-II', 'construction', 279000, 3, '7+', 740, '/models/products/excavator.glb'],
            ['Dragonborn Display Figure', 'mythos', 319000, 0, '10+', 530, '/models/products/dragonborn.glb'],
            ['Orbital Carrier Ship', 'vehicle', 209000, 7, '6+', 440, '/models/products/ship.glb'],
        ] as [$name, $categorySlug, $price, $stock, $age, $weight, $model]) {
            Product::updateOrCreate(
                ['slug' => str($name)->slug()->toString()],
                [
                    'id_category' => $categories[$categorySlug]->id_category,
                    'product_name' => $name,
                    'price' => $price,
                    'description' => 'Collector display toy dengan detail premium, material ABS, dan presentasi cocok untuk hadiah atau pajangan.',
                    'model_url' => $model,
                    'stock' => $stock,
                    'recommended_age' => $age,
                    'safety_note' => 'Mengandung bagian kecil. Tidak untuk anak di bawah 3 tahun.',
                    'size' => '18 cm',
                    'weight_gram' => $weight,
                    'status' => 'active',
                ]
            );
        }

        foreach ([
            ['Transfer Bank', 'Pembayaran simulasi melalui transfer bank'],
            ['Kartu Kredit', 'Pembayaran simulasi menggunakan kartu kredit'],
            ['COD', 'Pembayaran di tempat'],
        ] as [$name, $description]) {
            PaymentMethod::firstOrCreate(['method_name' => $name], ['description' => $description]);
        }

        foreach ([
            ['JNE', 'Pengiriman menggunakan JNE', [[0, 1000, 10000, 5000], [1001, 3000, 15000, 7000], [3001, 999999, 24000, 9000]]],
            ['GOJEK', 'Pengiriman menggunakan GOJEK', [[0, 1000, 12000, 6000], [1001, 3000, 18000, 8000], [3001, 999999, 28000, 10000]]],
        ] as [$name, $description, $rates]) {
            $method = ShippingMethod::firstOrCreate(['method_name' => $name], ['description' => $description]);
            foreach ($rates as [$min, $max, $base, $perKg]) {
                $method->rates()->firstOrCreate(
                    ['min_weight_gram' => $min, 'max_weight_gram' => $max],
                    ['base_cost' => $base, 'cost_per_kg' => $perKg]
                );
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
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

        // ponytail: seed only bootstrap reference data; live catalog comes from admin/import.
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

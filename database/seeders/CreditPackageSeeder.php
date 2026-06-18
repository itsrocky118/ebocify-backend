<?php

namespace Database\Seeders;

use App\Models\CreditPackage;
use Illuminate\Database\Seeder;

class CreditPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => '10 Credits',
                'credits' => 10,
                'price' => 5.99,
                'discount_percentage' => 0,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => '50 Credits',
                'credits' => 50,
                'price' => 24.99,
                'discount_percentage' => 16,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => '100 Credits',
                'credits' => 100,
                'price' => 39.99,
                'discount_percentage' => 33,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => '500 Credits',
                'credits' => 500,
                'price' => 149.99,
                'discount_percentage' => 50,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => '1000 Credits',
                'credits' => 1000,
                'price' => 249.99,
                'discount_percentage' => 58,
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($packages as $package) {
            CreditPackage::create($package);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Parts;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\Parts::factory(10)->create();
        $parts = [
            [
                'code' => 'P001',
                'name' => 'Break Pads',
                'stock' => 50,
                'dealer_price' => 200,
                'retail_price' => 250,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'P002',
                'name' => 'Oil Filter',
                'stock' => 30,
                'dealer_price' => 150,
                'retail_price' => 180,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'P003',
                'name' => 'Look Glass',
                'stock' => 20,
                'dealer_price' => 500,
                'retail_price' => 600,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'P004',
                'name' => 'Air Filter',
                'stock' => 40,
                'dealer_price' => 100,
                'retail_price' => 120,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'P005',
                'name' => 'Spark Plug',
                'stock' => 60,
                'dealer_price' => 80,
                'retail_price' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($parts as $part) {
            Parts::create($part);
        }
    }
}

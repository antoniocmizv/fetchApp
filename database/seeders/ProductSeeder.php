<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        
        $products = [];
        
        for($i = 0; $i < 20; $i++) {
            $products[] = [
                'name' => $faker->words(3, true),
                'price' => $faker->randomFloat(2, 10, 1000),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        
        Product::insert($products);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Contract;
use Faker\Factory as Faker;
class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contract = Contract::all();
        $faker = Faker::create();
        foreach ($contract as $c) {
            Product::create([
                'contract_id' => $c->id,
                'name' => $faker->name,
                'color' => $faker->colorName,
                'quantity' => $faker->numberBetween(1, 100),
                'price' => $faker->numberBetween(100000, 1000000),
                'gender' => $faker->randomElement(['male', 'female']),
                'size' => $faker->randomElement(['S', 'M', 'L', 'XL']),
                'material' => $faker->randomElement(['cotton', 'polyester', 'wool']),
                'description' => $faker->sentence,
            ]);
        }
    }
}

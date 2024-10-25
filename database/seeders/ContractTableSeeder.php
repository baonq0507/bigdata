<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contract;
use App\Models\PartyAInfo;
use App\Models\PartyBInfo;
use App\Models\User;
use App\Models\Post;
use Faker\Factory as Faker;

class ContractTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $partyAInfoIds = PartyAInfo::pluck('id')->toArray();
        $partyBInfoIds = PartyBInfo::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();
        $posts = Post::pluck('id')->toArray();
        for ($i = 0; $i < 50; $i++) {
            Contract::create([
                'code' => $faker->unique()->numberBetween(100000, 999999),
                'invoice_image' => $faker->imageUrl(),
                'product_image' => $faker->imageUrl(),
                'description' => $faker->text(),
                'total_amount' => $faker->randomFloat(2, 0, 10000),
                'deposit_amount' => $faker->randomFloat(2, 0, 5000),
                'confirmation_a' => $faker->boolean(),
                'confirmation_b' => $faker->boolean(),
                'confirmation_c' => $faker->boolean(),
                'terms_agreed' => $faker->boolean(),
                'status' => $faker->randomElement(Contract::STATUS),
                'estimated_delivery_date' => $faker->dateTimeBetween('now', '+1 year'),
                'id_party_a_info' => $faker->randomElement($partyAInfoIds),
                'id_party_b_info' => $faker->randomElement($partyBInfoIds),
                'id_user_b' => $faker->randomElement($users),
                'post_id' => $faker->randomElement($posts),
            ]);
        }
    }
}

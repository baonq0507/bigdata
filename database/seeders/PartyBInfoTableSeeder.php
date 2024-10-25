<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PartyBInfo;
use App\Models\User;
use App\Models\Contract;
use Faker\Factory as Faker;

class PartyBInfoTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $users = User::all();

        foreach ($users as $user) {
            PartyBInfo::create([
                'user_id' => $user->id,
                'email' => $faker->safeEmail(),
                'tax_id' => $faker->unique()->randomNumber(),
                'bank_account_number' => $faker->bankAccountNumber(),
                'bank_name' => $faker->company(),
                'business_name' => $faker->company(),
                'position' => $faker->jobTitle(),
                'address' => $faker->address(),
                'phone_number' => $faker->phoneNumber(),
                'full_name' => $faker->name(),
            ]);
        }
    }
}

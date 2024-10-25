<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PartyAInfo;
use App\Models\User;
use App\Models\Contract;
use Faker\Factory as Faker;

class PartyAInfoTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $users = User::all();

        foreach ($users as $user) {
            PartyAInfo::create([
                'user_id' => $user->id,
                'account_number' => $faker->bankAccountNumber(),
                'email' => $faker->safeEmail(),
                'bank_name' => $faker->company(),
                'address' => $faker->address(),
                'recipient_name' => $faker->name(),
            ]);
        }
    }
}

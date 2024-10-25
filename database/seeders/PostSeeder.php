<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use Faker\Factory as Faker;
class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $users = User::pluck('id')->toArray();
        foreach ($users as $user) {
            Post::create([
                'user_id' => $user,
                'title' => $faker->sentence(),
                'content' => $faker->text(),
                'field' => $faker->randomElement(Post::FIELD),
                'type' => $faker->randomElement(Post::TYPE),
                'status' => $faker->randomElement(Post::STATUS),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Jobs\SeedUsersJob;
use Database\Factories\UserFactory;
use DB;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    public function run()
    {
        if (User::where('email', 'admin@example.com')->count() === 0) {
            DB::table('users')->insert([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'phone' => '0396130621',
                'store_name'=>'store name',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]);
        }
        else {
            //cập nhật lại mật khẩu
            User::where('email', 'admin@example.com')->update([
                'password' => Hash::make('password')
            ]);
        }
        //tạo seed acc demo
        if (User::where('email', 'demo@demo.com')->count() === 0) {
            DB::table('users')->insert([
                'name' => 'Demo',
                'email' => 'demo@demo.com',
                'email_verified_at' => now(),
                'phone' => '0396130622',
                'store_name' => 'store name',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]);
        }
    }
}

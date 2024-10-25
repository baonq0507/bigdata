<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Field\app\Models\Field;

class FieldSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            Field::create([
                'name' => 'Field ' . $i,
                'icon' => 'https://example.com/icon' . $i . '.png',
                'status' => 'active',
            ]);
        }
    }
}

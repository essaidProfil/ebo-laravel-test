<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Simple User',
            'email' => 'admin@example.com',
            'user_role' => 2,
            'password' => bcrypt('password'),
        ]);
    }
}


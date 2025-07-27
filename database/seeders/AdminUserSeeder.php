<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'abisma410@gmail.com'],
            [
                'name' => 'Admin',
                'email' => 'abisma410@gmail.com',
                'password' => Hash::make('11111111'),
                'role' => 'admin',
            ]
        );
    }
}

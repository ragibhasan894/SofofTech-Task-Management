<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            [
                'name'       => 'Admin User',
                'email'      => 'admin@example.com',
                'password'   => Hash::make('admin'),
                'role'       => 'admin',
                'created_at' => now(),
            ],
            [
                'name'       => 'Ragib',
                'email'      => 'ragib@example.com',
                'password'   => Hash::make('ragib'),
                'role'       => 'user',
                'created_at' => now(),
            ],
            [
                'name'       => 'Hasnat',
                'email'      => 'hasnat@example.com',
                'password'   => Hash::make('hasnat'),
                'role'       => 'user',
                'created_at' => now(),
            ]
        ]);
    }
}

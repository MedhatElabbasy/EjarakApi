<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $users = [
            [
                'name' => 'John Doe',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
                'role_id' => 1, // Replace with the appropriate role ID
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'owner@owner.com',
                'password' => Hash::make('owner'),
                'role_id' => 2, // Replace with the appropriate role ID
            ],
            [
                'name' => 'Michael Johnson',
                'email' => 'customer@customer.com',
                'password' => Hash::make('customer'),
                'role_id' => 3, // Replace with the appropriate role ID
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

    }
}
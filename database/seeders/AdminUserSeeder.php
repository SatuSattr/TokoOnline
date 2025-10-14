<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure a default admin user exists
        User::updateOrCreate(
            ['email' => 'admin@tokoonline.test'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'), // Update as needed
                'role' => User::ROLE_ADMIN,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SellerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sellers = [
            [
                'name' => 'First Seller',
                'email' => 'seller1@tokoonline.test',
            ],
            [
                'name' => 'Second Seller',
                'email' => 'seller2@tokoonline.test',
            ],
        ];

        foreach ($sellers as $seller) {
            User::updateOrCreate(
                ['email' => $seller['email']],
                [
                    'name' => $seller['name'],
                    'password' => Hash::make('password'),
                    'role' => User::ROLE_SELLER,
                ]
            );
        }
    }
}

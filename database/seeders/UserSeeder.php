<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserSetting;
use App\Models\NotificationPreference;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => 'admin@ebocify.com',
                'phone' => '01712345678',
                'phone_code' => '+880',
                'password' => Hash::make('password'),
                'job_title' => 'Administrator',
                'country' => 'Bangladesh',
                'company_name' => 'Ebocify Ltd.',
                'company_address' => 'Dhaka, Bangladesh',
                'email_verified_at' => now(),
                'status' => 'active',
            ],
            [
                'first_name' => 'Demo',
                'last_name' => 'User',
                'email' => 'demo@ebocify.com',
                'phone' => '01787654321',
                'phone_code' => '+880',
                'password' => Hash::make('password'),
                'job_title' => 'Exporter',
                'country' => 'Bangladesh',
                'company_name' => 'Demo Company',
                'company_address' => 'Chittagong, Bangladesh',
                'erc_number' => 'ERC123456',
                'tin_number' => 'TIN789012',
                'email_verified_at' => now(),
                'status' => 'active',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create($userData);

            // Create user settings
            UserSetting::create([
                'user_id' => $user->id,
                'timezone' => 'Asia/Dhaka',
                'language' => 'en',
            ]);

            // Create notification preferences
            NotificationPreference::create([
                'user_id' => $user->id,
            ]);
        }
    }
}

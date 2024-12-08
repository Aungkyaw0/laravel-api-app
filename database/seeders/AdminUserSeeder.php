<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'password' => Hash::make('13321983@@'),
                'role' => 'admin',
            ]
        );

        Admin::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name' => 'System Administrator',
                'phone' => '1234567890'
            ]
        );
    }
} 
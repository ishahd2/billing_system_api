<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        $admin = User::where('email', 'admin@admin.com')->first();
        if (!$admin) {
            $admin = new User();
            $admin->name = 'Admin';
            $admin->email = 'admin@admin.com';
            $admin->password = bcrypt('password');
            $admin->role = UserRole::ADMIN;
            $admin->email_verified_at = now();
            $admin->save();
        }

        // User
        $user = User::where('email', 'user@user.com')->first();
        if (!$user) {
            $user = new User();
            $user->name = 'User';
            $user->email = 'user@user.com';
            $user->password = bcrypt('password');
            $user->role = UserRole::USER;
            $user->email_verified_at = now();
            $user->save();
        }
    }
}

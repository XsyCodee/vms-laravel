<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@vms-dcms.com'],
            [
                'name' => 'Admin VMS',
                'email' => 'admin@vms-dcms.com',
                'password' => Hash::make('password123'),
            ]
        );

        $this->command->info('Admin user created: admin@vms-dcms.com / password123');
    }
}
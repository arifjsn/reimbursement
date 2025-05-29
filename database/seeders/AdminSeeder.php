<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Role::updateOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web'
        ], []);

        $adminUser = User::updateOrCreate([
            'email' => 'sales@jasanet.co.id'
        ], [
            'name' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('Setup1PW!')
        ]);

        $adminUser->assignRole('Admin');
    }
}

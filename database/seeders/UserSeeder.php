<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        Role::updateOrCreate([
            'name' => 'User',
            'guard_name' => 'web'
        ], []);

        $users = [
            [
                'email' => 'sales3@jasanet.co.id',
                'name' => 'Dani Praseyta',
                'username' => 'dani'
            ],
            [
                'email' => 'arif@jasanet.co.id',
                'name' => 'Arif Febrianto',
                'username' => 'arif'
            ],
            [
                'email' => 'iqbal@jasanet.co.id',
                'name' => 'Muhammad Iqbal',
                'username' => 'iqbal'
            ],
            [
                'email' => 'aris@jasanet.co.id',
                'name' => 'Aris',
                'username' => 'aris'
            ],
        ];

        foreach ($users as $u) {
            $user = User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'username' => $u['username'],
                    'password' => Hash::make('Setup1PW!')
                ]
            );
            $user->assignRole('User');
        }
    }
}

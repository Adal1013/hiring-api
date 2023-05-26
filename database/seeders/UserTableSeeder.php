<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $users = [
            [
                'username' => 'adal123',
                'is_active' => 1,
                'role' => 'manager',
            ],
            [
                'username' => 'jose123',
                'is_active' => 1,
                'role' => 'agent',
            ],
            [
                'username' => 'italo123',
                'is_active' => 0,
                'role' => 'agent',
            ],
        ];
        foreach ($users as $user) {
            $user = User::updateOrCreate(
                ['username' => $user['username']],
                $user
            );
            $user->assignRole($user['role']);
        }
    }
}

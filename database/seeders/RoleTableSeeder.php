<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Role::create(['name' => 'manager', 'guard_name' => 'api',]);
        Role::create(['name' => 'agent', 'guard_name' => 'api',]);
        Permission::create(['name' => 'create candidates', 'guard_name' => 'api',]);
        Permission::create(['name' => 'view all candidates', 'guard_name' => 'api',]);
        Permission::create(['name' => 'view assigned candidates', 'guard_name' => 'api',]);
        Role::findByName('manager', 'api')->givePermissionTo('create candidates');
        Role::findByName('manager', 'api')->givePermissionTo('view all candidates');
        Role::findByName('agent', 'api')->givePermissionTo('view assigned candidates');
    }
}

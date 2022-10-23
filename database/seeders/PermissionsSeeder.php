<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'list accounts']);
        Permission::create(['name' => 'view accounts']);
        Permission::create(['name' => 'create accounts']);
        Permission::create(['name' => 'update accounts']);
        Permission::create(['name' => 'delete accounts']);

        Permission::create(['name' => 'list assigns']);
        Permission::create(['name' => 'view assigns']);
        Permission::create(['name' => 'create assigns']);
        Permission::create(['name' => 'update assigns']);
        Permission::create(['name' => 'delete assigns']);

        Permission::create(['name' => 'list banks']);
        Permission::create(['name' => 'view banks']);
        Permission::create(['name' => 'create banks']);
        Permission::create(['name' => 'update banks']);
        Permission::create(['name' => 'delete banks']);

        Permission::create(['name' => 'list clusters']);
        Permission::create(['name' => 'view clusters']);
        Permission::create(['name' => 'create clusters']);
        Permission::create(['name' => 'update clusters']);
        Permission::create(['name' => 'delete clusters']);

        Permission::create(['name' => 'list colors']);
        Permission::create(['name' => 'view colors']);
        Permission::create(['name' => 'create colors']);
        Permission::create(['name' => 'update colors']);
        Permission::create(['name' => 'delete colors']);

        Permission::create(['name' => 'list executeds']);
        Permission::create(['name' => 'view executeds']);
        Permission::create(['name' => 'create executeds']);
        Permission::create(['name' => 'update executeds']);
        Permission::create(['name' => 'delete executeds']);

        Permission::create(['name' => 'list expenses']);
        Permission::create(['name' => 'view expenses']);
        Permission::create(['name' => 'create expenses']);
        Permission::create(['name' => 'update expenses']);
        Permission::create(['name' => 'delete expenses']);

        Permission::create(['name' => 'list incomes']);
        Permission::create(['name' => 'view incomes']);
        Permission::create(['name' => 'create incomes']);
        Permission::create(['name' => 'update incomes']);
        Permission::create(['name' => 'delete incomes']);

        Permission::create(['name' => 'list purposes']);
        Permission::create(['name' => 'view purposes']);
        Permission::create(['name' => 'create purposes']);
        Permission::create(['name' => 'update purposes']);
        Permission::create(['name' => 'delete purposes']);

        Permission::create(['name' => 'list types']);
        Permission::create(['name' => 'view types']);
        Permission::create(['name' => 'create types']);
        Permission::create(['name' => 'update types']);
        Permission::create(['name' => 'delete types']);

        // Create user role and assign existing permissions
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo($currentPermissions);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'super-admin']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::whereEmail('admin@admin.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}

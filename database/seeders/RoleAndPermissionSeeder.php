<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Buat daftar permissions yang dibutuhkan sistem
        $permissions = [
            'view-departments', 'create-departments', 'edit-departments', 'delete-departments',
            
            'view-positions', 'create-positions', 'edit-positions', 'delete-positions',
            
            'view-employees', 'create-employees', 'edit-employees', 'delete-employees',
            
            'view-users', 'create-users', 'edit-users', 'delete-users',
            
            'view-roles', 'create-roles', 'edit-roles', 'delete-roles',

            'view-products', 'create-products', 'edit-products', 'delete-products',

            'view-stock_mutations', 'create-stock_mutations', 'edit-stock_mutations', 'delete-stock_mutations',

            'reset-demo', 'import-demo',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $hrRole = Role::firstOrCreate(['name' => 'hr']);
        $hrRole->givePermissionTo([
            'view-departments', 'view-positions', 

            'view-employees', 'create-employees', 'edit-employees',

            'view-users', 'create-users', 'edit-users',
        ]);

        $gudangRole = Role::firstOrCreate(['name' => 'gudang']);
        $gudangRole->givePermissionTo([
            'view-products', 'create-products', 'edit-products',

            'view-stock_mutations', 'create-stock_mutations'
        ]);

        $ownerRole = Role::firstOrCreate(['name' => 'owner']);
        $ownerRole->givePermissionTo(Permission::all());

        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $managerRole->givePermissionTo([
            'view-departments', 'create-departments', 'edit-departments',
            
            'view-positions', 'create-positions', 'edit-positions',
            
            'view-employees', 'create-employees', 'edit-employees',
            
            'view-users', 'create-users', 'edit-users',
            
            'view-roles', 'create-roles', 'edit-roles',

            'view-products', 'create-products', 'edit-products', 

            'view-stock_mutations', 'create-stock_mutations', 'edit-stock_mutations',
        ]);
    }
}
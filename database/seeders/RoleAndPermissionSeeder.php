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

        $hrRole = Role::firstOrCreate(['name' => 'gudang']);
        $hrRole->givePermissionTo([
            'view-products', 'create-products', 'edit-products',

            'view-stock_mutations', 'create-stock_mutations', 'edit-stock_mutations'
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
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

        // 2. Buat role admin dan berikan semua permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // 3. Buat role HR / lainnya jika perlu
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
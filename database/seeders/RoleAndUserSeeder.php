<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roleAdmin   = Role::firstOrCreate(['name' => 'admin']);
        $roleHr      = Role::firstOrCreate(['name' => 'hr']);
        $roleEmp     = Role::firstOrCreate(['name' => 'employee']);
        $roleGudang  = Role::firstOrCreate(['name' => 'gudang']);
        $roleOwner   = Role::firstOrCreate(['name' => 'owner']);
        $roleManajer = Role::firstOrCreate(['name' => 'manajer']);

        $admin = User::create([
            'name' => 'SuperAdmin',
            'email' => 'admin@syailendra.com',
            'password' => Hash::make('password123'),
        ]);
        $admin->assignRole(['admin', 'owner']);

        $hr = User::create([
            'name' => 'HR',
            'email' => 'hr@syailendra.com',
            'password' => Hash::make('password123'),
        ]);
        $hr->assignRole('hr');

        $employee = User::create([
            'name' => 'employee',
            'email' => 'employee@Syailendra.com',
            'password' => Hash::make('password123'),
        ]);
        $employee->assignRole('employee');

        $gudangUser = User::create([
            'name' => 'gudang',
            'email' => 'gudang@syailendra.com',
            'password' => Hash::make('password123'),
        ]);
        $gudangUser->assignRole('gudang');

        $ownerUser = User::create([
            'name' => 'owner',
            'email' => 'owner@syailendra.com',
            'password' => Hash::make('password123'),
        ]);
        $ownerUser->assignRole('owner');

        $managerUser = User::create([
            'name' => 'manajer',
            'email' => 'manajer@syailendra.com',
            'password' => Hash::make('password123'),
        ]);
        $managerUser->assignRole('manajer');
    }
}
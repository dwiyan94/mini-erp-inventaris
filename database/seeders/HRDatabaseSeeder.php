<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Position;
use App\Models\Employee;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HRDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat 10 Role (Spatie)
        $roleNames = [
            'Super Admin', 'HR Manager', 'HR Staff', 'Finance Manager', 
            'Finance Staff', 'IT Manager', 'Software Engineer', 'Operations Manager', 
            'Marketing Lead', 'Employee'
        ];
        
        $roles = [];
        foreach ($roleNames as $roleName) {
            $roles[] = Role::firstOrCreate(['name' => Str::slug($roleName)]);
        }

        // 2. Buat 10 Departemen
        $deptNames = [
            'Information Technology', 'Human Resources', 'Finance & Accounting', 
            'Operations', 'Marketing & Sales', 'Legal & Compliance', 
            'Research & Development', 'Customer Support', 'Procurement', 'General Affairs'
        ];

        $departments = [];
        foreach ($deptNames as $name) {
            $departments[] = Department::firstOrCreate(['name' => $name]);
        }

        // 3. Buat 30 Posisi (3 posisi per departemen)
        $positions = [];
        $positionTitles = ['Manager', 'Senior Specialist', 'Junior Specialist', 'Lead', 'Staff'];

        foreach ($departments as $dept) {
            for ($i = 1; $i <= 3; $i++) {
                $title = $positionTitles[array_rand($positionTitles)];
                $positions[] = Position::create([
                    'department_id' => $dept->id,
                    'name' => $dept->name . ' - ' . $title . ' ' . $i
                ]);
            }
        }

        // 4. Buat 100 Pekerja (Employee) & 100 User yang terikat
        for ($i = 1; $i <= 500; $i++) {
            $nik = 'EMP' . str_pad($i, 4, '0', STR_PAD_LEFT);
            $name = fake()->name();
            $email = fake()->unique()->safeEmail();
            
            $position = $positions[array_rand($positions)];

            $employee = Employee::create([
                'nik' => $nik,
                'name' => $name,
                'phone' => '08' . fake()->numerify('##########'), // Nomor HP dummy
                'photo' => 'default.jpg', // Atau biarkan null
                'position_id' => $position->id,
                'join_date' => fake()->dateTimeBetween('-3 years', 'now')->format('Y-m-d'),
            ]);

            $user = User::create([
                'employee_id' => $employee->id,
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('password'), // Password default: password
            ]);

            // Tetapkan role secara acak ke user
            $randomRole = $roles[array_rand($roles)];
            $user->assignRole($randomRole);
        }


    }


}
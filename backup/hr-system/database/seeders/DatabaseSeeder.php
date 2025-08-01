<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Departments
        $hr = Department::create(['name' => 'Human Resources']);
        $it = Department::create(['name' => 'Information Technology']);

        // Designations
        $manager = Designation::create(['title' => 'Manager']);
        $developer = Designation::create(['title' => 'Developer']);

        // Employees
        $adminEmployee = Employee::create([
            'department_id' => $hr->id,
            'designation_id' => $manager->id,
            'first_name' => 'Admin',
            'last_name' => 'User',
            'dob' => '1980-01-01',
            'address' => '123 Admin Street',
            'nrc' => '12/ABC123456',
            'phonenumber' => '1234567890',
            'email' => 'admin@example.com',
            'status' => 'permanent',
            'basic_salary' => 1500000.00,
        ]);

        $hrEmployee = Employee::create([
            'department_id' => $hr->id,
            'designation_id' => $manager->id,
            'first_name' => 'HR',
            'last_name' => 'User',
            'dob' => '1985-01-01',
            'address' => '123 HR Street',
            'nrc' => '12/DEF123456',
            'phonenumber' => '0987654321',
            'email' => 'hr@example.com',
            'status' => 'permanent',
            'basic_salary' => 1500000.00,
        ]);

        $employee = Employee::create([
            'department_id' => $it->id,
            'designation_id' => $developer->id,
            'first_name' => 'Employee',
            'last_name' => 'User',
            'dob' => '1990-01-01',
            'address' => '123 Employee Street',
            'nrc' => '12/GHI123456',
            'phonenumber' => '1112223333',
            'email' => 'employee@example.com',
            'status' => 'intern',
            'basic_salary' => 1000000.00,
        ]);

        // Users
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'user_type' => 'admin',
            'employee_id' => $adminEmployee->id,
        ]);

        User::create([
            'name' => 'HR User',
            'email' => 'hr@example.com',
            'password' => bcrypt('password'),
            'user_type' => 'hr',
            'employee_id' => $hrEmployee->id,
        ]);

        User::create([
            'name' => 'Employee User',
            'email' => 'employee@example.com',
            'password' => bcrypt('password'),
            'user_type' => 'employee',
            'employee_id' => $employee->id,
        ]);

        // Employee without user account
        Employee::create([
            'department_id' => $it->id,
            'designation_id' => $developer->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'dob' => '1995-01-01',
            'address' => '123 Main Street',
            'nrc' => '12/JKL123456',
            'phonenumber' => '4445556666',
            'email' => 'john.doe@example.com',
            'status' => 'contracted',
            'basic_salary' => 1500000.00,
        ]);
    }
}
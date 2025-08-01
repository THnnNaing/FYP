<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Database\Seeder;

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

        // Leave Types
        $sick = LeaveType::create(['name' => 'Sick Leave', 'is_paid' => true]);
        $vacation = LeaveType::create(['name' => 'Vacation Leave', 'is_paid' => true]);
        $unpaid = LeaveType::create(['name' => 'Unpaid Leave', 'is_paid' => false]);

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
            'basic_salary' => 1500000.0,
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
            'basic_salary' => 1500000.0,
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
            'basic_salary' => 1000000.0,
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
            'basic_salary' => 1500000.0,
        ]);

        // Leaves
        Leave::create([
            'employee_id' => $employee->id,
            'leave_type_id' => $sick->id,
            'start_date' => now(),
            'end_date' => now()->addDays(2),
            'reason' => 'Medical appointment',
            'status' => 'pending',
        ]);

        Leave::create([
            'employee_id' => $hrEmployee->id,
            'leave_type_id' => $vacation->id,
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(7),
            'reason' => 'Family vacation',
            'status' => 'approved',
            'approved_by' => User::where('user_type', 'admin')->first()->id,
            'approved_at' => now(),
        ]);
    }
}

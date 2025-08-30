<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\User;
use App\Models\PayrollSetting;
use App\Models\Payroll;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

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

        // Payroll Settings
        PayrollSetting::create(['name' => 'Tax Rate', 'value' => 15.00]);

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
            'status' => 'permanent', // Reverted to original
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
            'status' => 'permanent', // Reverted to original
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
            'status' => 'intern', // Reverted to original
            'basic_salary' => 1000000.00,
        ]);

        $johnDoe = Employee::create([
            'department_id' => $it->id,
            'designation_id' => $developer->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'dob' => '1995-01-01',
            'address' => '123 Main Street',
            'nrc' => '12/JKL123456',
            'phonenumber' => '4445556666',
            'email' => 'john.doe@example.com',
            'status' => 'contracted', // Reverted to original
            'basic_salary' => 1500000.00,
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

        // Leaves
        Leave::create([
            'employee_id' => $employee->id,
            'leave_type_id' => $sick->id,
            'start_date' => '2025-08-05',
            'end_date' => '2025-08-07',
            'reason' => 'Medical appointment',
            'status' => 'pending',
        ]);

        Leave::create([
            'employee_id' => $hrEmployee->id,
            'leave_type_id' => $vacation->id,
            'start_date' => '2025-08-10',
            'end_date' => '2025-08-12',
            'reason' => 'Family vacation',
            'status' => 'approved',
            'approved_by' => User::where('user_type', 'admin')->first()->id,
            'approved_at' => now(),
        ]);

        Leave::create([
            'employee_id' => $employee->id,
            'leave_type_id' => $unpaid->id,
            'start_date' => '2025-08-01',
            'end_date' => '2025-08-03',
            'reason' => 'Personal reasons',
            'status' => 'approved',
            'approved_by' => User::where('user_type', 'hr')->first()->id,
            'approved_at' => now(),
        ]);

        // Payrolls
        $periodStart = Carbon::parse('2025-08-01');
        $periodEnd = Carbon::parse('2025-08-31');
        $basicSalary = $employee->basic_salary; // 1000000.00
        $periodDays = $periodStart->diffInDays($periodEnd) + 1; // 31 days
        $dailySalary = $basicSalary / $periodDays; // ~32258.06
        $leaveDays = 3; // From unpaid leave (2025-08-01 to 2025-08-03)
        $leaveDeductions = $leaveDays * $dailySalary; // ~96774.19
        $taxDeductions = ($basicSalary * 15) / 100; // 15% of 1000000 = 150000.00
        $netSalary = $basicSalary - $leaveDeductions - $taxDeductions; // 1000000 - 96774.19 - 150000 = ~753225.81

        Payroll::create([
            'employee_id' => $employee->id,
            'period_start' => '2025-08-01',
            'period_end' => '2025-08-31',
            'basic_salary' => $basicSalary,
            'leave_deductions' => round($leaveDeductions, 2),
            'tax_deductions' => round($taxDeductions, 2),
            'other_deductions' => 0,
            'net_salary' => round($netSalary, 2),
            'status' => 'draft',
        ]);
    }
}
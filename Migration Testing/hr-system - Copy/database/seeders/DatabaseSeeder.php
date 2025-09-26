<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use App\Models\LeaveType;
use App\Models\Leave;
use App\Models\BonusType;
use App\Models\DeductionType;
use App\Models\Payroll;
use App\Models\PayrollBonus;
use App\Models\PayrollDeduction;
use App\Models\TrainingProgram;
use App\Models\TrainingAssignment;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Departments
        $it = Department::create(['name' => 'IT']);
        $hr = Department::create(['name' => 'HR']);

        // Designations
        $developer = Designation::create(['title' => 'Developer']);
        $manager = Designation::create(['title' => 'Manager']);

        // Leave Types
        $sick = LeaveType::create(['name' => 'Sick Leave', 'is_paid' => true]);
        $vacation = LeaveType::create(['name' => 'Vacation Leave', 'is_paid' => true]);
        $unpaid = LeaveType::create(['name' => 'Unpaid Leave', 'is_paid' => false]);

        // Bonus Types
        $performance = BonusType::create(['name' => 'Performance Bonus', 'description' => 'For outstanding performance']);
        $holiday = BonusType::create(['name' => 'Holiday Bonus', 'description' => 'Year-end bonus']);

        // Deduction Types
        $tax = DeductionType::create(['name' => 'Tax', 'description' => 'Income tax deduction']);
        $penalty = DeductionType::create(['name' => 'Late Penalty', 'description' => 'Penalty for late attendance']);

        // Users and Employees
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'user_type' => 'admin',
        ]);

        $hrUser = User::create([
            'name' => 'HR User',
            'email' => 'hr@example.com',
            'password' => bcrypt('password'),
            'user_type' => 'hr',
        ]);

        $employeeUser = User::create([
            'name' => 'Employee User',
            'email' => 'employee@example.com',
            'password' => bcrypt('password'),
            'user_type' => 'employee',
        ]);

        $employee1 = Employee::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'dob' => '1990-01-01',
            'address' => '123 Main St',
            'nrc' => '12/ABC123456',
            'phonenumber' => '1234567890',
            'email' => 'john.doe@example.com',
            'status' => 'permanent',
            'basic_salary' => 30000.00,
            'department_id' => $it->id,
            'designation_id' => $developer->id,
            'user_id' => $employeeUser->id,
        ]);

        $employeeUser->update(['employee_id' => $employee1->id]);

        $employee2 = Employee::create([
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'dob' => '1992-02-02',
            'address' => '456 Elm St',
            'nrc' => '13/DEF654321',
            'phonenumber' => '0987654321',
            'email' => 'jane.smith@example.com',
            'status' => 'intern',
            'basic_salary' => 15000.00,
            'department_id' => $hr->id,
            'designation_id' => $manager->id,
        ]);

        // Leaves
        Leave::create([
            'employee_id' => $employee1->id,
            'leave_type_id' => $unpaid->id,
            'start_date' => Carbon::now()->startOfMonth(),
            'end_date' => Carbon::now()->startOfMonth()->addDays(2),
            'reason' => 'Personal reasons',
            'status' => 'approved',
            'approved_by' => $hrUser->id,
            'approved_at' => now(),
        ]);

        Leave::create([
            'employee_id' => $employee2->id,
            'leave_type_id' => $vacation->id,
            'start_date' => Carbon::now()->startOfMonth()->addDays(5),
            'end_date' => Carbon::now()->startOfMonth()->addDays(7),
            'reason' => 'Family vacation',
            'status' => 'approved',
            'approved_by' => $hrUser->id,
            'approved_at' => now(),
        ]);

        // Payrolls
        $payroll1 = Payroll::create([
            'employee_id' => $employee1->id,
            'month' => Carbon::now()->startOfMonth()->subMonth(),
            'basic_salary' => 30000.00,
            'worked_days' => 27,
            'unpaid_leave_days' => 3,
            'total_bonus' => 1000.00,
            'total_deduction' => 500.00,
            'net_salary' => (30000.00 / 30 * 27) + 1000.00 - 500.00,
            'status' => 'approved',
            'approved_by' => $hrUser->id,
            'approved_at' => now(),
        ]);

        PayrollBonus::create([
            'payroll_id' => $payroll1->id,
            'bonus_type_id' => $performance->id,
            'amount' => 1000.00,
        ]);

        PayrollDeduction::create([
            'payroll_id' => $payroll1->id,
            'deduction_type_id' => $tax->id,
            'amount' => 500.00,
        ]);

        Payroll::create([
            'employee_id' => $employee2->id,
            'month' => Carbon::now()->startOfMonth()->subMonth(),
            'basic_salary' => 15000.00,
            'worked_days' => 20,
            'unpaid_leave_days' => 0,
            'total_bonus' => 0,
            'total_deduction' => 0,
            'net_salary' => (15000.00 / 30 * 20),
            'status' => 'pending',
        ]);

        // Training Programs
        $trainingProgram = TrainingProgram::create([
            'name' => 'Laravel Advanced Training',
            'details' => 'Learn advanced Laravel concepts for enterprise applications.',
            'instructor_employee_id' => $employee1->id,
            'available_days' => ['Mon', 'Wed', 'Fri'],
            'available_total_employees' => 20,
            'available_time' => '4:00pm to 6:00pm',
            'status' => 'available',
        ]);

        // Training Assignments
        TrainingAssignment::create([
            'training_program_id' => $trainingProgram->id,
            'employee_id' => $employee2->id,
            'status' => 'pending',
            'start_date' => Carbon::now()->startOfMonth(),
            'end_date' => Carbon::now()->startOfMonth()->addDays(30),
        ]);
    }
}
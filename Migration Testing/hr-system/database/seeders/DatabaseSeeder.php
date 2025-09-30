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
        // Departments (10 records)
        $departments = [];
        $departmentNames = ['IT', 'HR', 'Finance', 'Marketing', 'Sales', 'Operations', 'Legal', 'Customer Support', 'Research', 'Engineering'];
        foreach ($departmentNames as $name) {
            $departments[] = Department::create(['name' => $name]);
        }

        // Designations (10 records)
        $designations = [];
        $designationTitles = [
            'Developer', 'Manager', 'Analyst', 'Designer', 'Accountant', 'Sales Executive', 
            'HR Specialist', 'Project Lead', 'Support Agent', 'Engineer'
        ];
        foreach ($designationTitles as $title) {
            $designations[] = Designation::create(['title' => $title]);
        }

        // Leave Types (10 records)
        $leaveTypes = [];
        $leaveTypeData = [
            ['name' => 'Sick Leave', 'is_paid' => true],
            ['name' => 'Vacation Leave', 'is_paid' => true],
            ['name' => 'Unpaid Leave', 'is_paid' => false],
            ['name' => 'Maternity Leave', 'is_paid' => true],
            ['name' => 'Paternity Leave', 'is_paid' => true],
            ['name' => 'Bereavement Leave', 'is_paid' => true],
            ['name' => 'Personal Leave', 'is_paid' => false],
            ['name' => 'Study Leave', 'is_paid' => false],
            ['name' => 'Sabbatical Leave', 'is_paid' => false],
            ['name' => 'Emergency Leave', 'is_paid' => true],
        ];
        foreach ($leaveTypeData as $data) {
            $leaveTypes[] = LeaveType::create($data);
        }

        // Bonus Types (10 records)
        $bonusTypes = [];
        $bonusTypeData = [
            ['name' => 'Performance Bonus', 'description' => 'For outstanding performance'],
            ['name' => 'Holiday Bonus', 'description' => 'Year-end bonus'],
            ['name' => 'Project Completion Bonus', 'description' => 'For completing major projects'],
            ['name' => 'Attendance Bonus', 'description' => 'For perfect attendance'],
            ['name' => 'Referral Bonus', 'description' => 'For employee referrals'],
            ['name' => 'Overtime Bonus', 'description' => 'For extra hours worked'],
            ['name' => 'Team Achievement Bonus', 'description' => 'For team milestones'],
            ['name' => 'Innovation Bonus', 'description' => 'For innovative ideas'],
            ['name' => 'Loyalty Bonus', 'description' => 'For long-term service'],
            ['name' => 'Safety Bonus', 'description' => 'For maintaining safety standards'],
        ];
        foreach ($bonusTypeData as $data) {
            $bonusTypes[] = BonusType::create($data);
        }

        // Deduction Types (10 records)
        $deductionTypes = [];
        $deductionTypeData = [
            ['name' => 'Tax', 'description' => 'Income tax deduction'],
            ['name' => 'Late Penalty', 'description' => 'Penalty for late attendance'],
            ['name' => 'Health Insurance', 'description' => 'Employee health insurance contribution'],
            ['name' => 'Loan Repayment', 'description' => 'Repayment of company loan'],
            ['name' => 'Absenteeism Penalty', 'description' => 'Penalty for unexcused absences'],
            ['name' => 'Equipment Damage', 'description' => 'Cost for damaged company property'],
            ['name' => 'Pension Contribution', 'description' => 'Employee pension plan deduction'],
            ['name' => 'Union Fees', 'description' => 'Union membership fees'],
            ['name' => 'Overpayment Recovery', 'description' => 'Recovery of payroll overpayments'],
            ['name' => 'Travel Advance Recovery', 'description' => 'Recovery of travel advances'],
        ];
        foreach ($deductionTypeData as $data) {
            $deductionTypes[] = DeductionType::create($data);
        }

        // Users (10 records)
        $users = [];
        $userData = [
            ['name' => 'Admin User', 'email' => 'admin@example.com', 'user_type' => 'admin'],
            ['name' => 'HR User', 'email' => 'hr@example.com', 'user_type' => 'hr'],
            ['name' => 'Employee User 1', 'email' => 'employee1@example.com', 'user_type' => 'employee'],
            ['name' => 'Employee User 2', 'email' => 'employee2@example.com', 'user_type' => 'employee'],
            ['name' => 'Employee User 3', 'email' => 'employee3@example.com', 'user_type' => 'employee'],
            ['name' => 'Manager User', 'email' => 'manager@example.com', 'user_type' => 'hr'],
            ['name' => 'Finance User', 'email' => 'finance@example.com', 'user_type' => 'hr'],
            ['name' => 'Support User', 'email' => 'support@example.com', 'user_type' => 'employee'],
            ['name' => 'Engineer User', 'email' => 'engineer@example.com', 'user_type' => 'employee'],
            ['name' => 'Analyst User', 'email' => 'analyst@example.com', 'user_type' => 'employee'],
        ];
        foreach ($userData as $data) {
            $users[] = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt('password'),
                'user_type' => $data['user_type'],
            ]);
        }

        // Employees (12 records, >10 for pagination testing)
        $employees = [];
        $firstNames = ['John', 'Jane', 'Alice', 'Bob', 'Charlie', 'Diana', 'Eve', 'Frank', 'Grace', 'Henry', 'Isabel', 'Jack'];
        $lastNames = ['Doe', 'Smith', 'Johnson', 'Brown', 'Taylor', 'Wilson', 'Davis', 'Clark', 'Lewis', 'Walker', 'Hall', 'Allen'];
        $statuses = ['permanent', 'contract', 'intern', 'terminated'];
        foreach (range(0, 11) as $i) {
            $employee = Employee::create([
                'first_name' => $firstNames[$i],
                'last_name' => $lastNames[$i],
                'dob' => Carbon::now()->subYears(rand(20, 50))->format('Y-m-d'),
                'address' => "Address $i, Main St",
                'nrc' => sprintf('%d/ABC%06d', rand(10, 99), $i + 100000),
                'phonenumber' => '123456789' . $i,
                'email' => "employee{$i}@example.com",
                'status' => $statuses[array_rand($statuses)],
                'basic_salary' => rand(15000, 50000) + 0.00,
                'department_id' => $departments[array_rand($departments)]->id,
                'designation_id' => $designations[array_rand($designations)]->id,
                'user_id' => ($i < 3) ? $users[$i + 2]->id : null, // Link first 3 employees to employee users
            ]);
            $employees[] = $employee;
            if ($i < 3) {
                $users[$i + 2]->update(['employee_id' => $employee->id]);
            }
        }

        // Leaves (10 records)
        $leaves = [];
        foreach (range(0, 9) as $i) {
            $employee = $employees[array_rand($employees)];
            $leaveType = $leaveTypes[array_rand($leaveTypes)];
            $startDate = Carbon::now()->startOfMonth()->addDays(rand(0, 15));
            $leaves[] = Leave::create([
                'employee_id' => $employee->id,
                'leave_type_id' => $leaveType->id,
                'start_date' => $startDate,
                'end_date' => $startDate->addDays(rand(1, 5)),
                'reason' => "Reason for leave $i",
                'status' => ['pending', 'approved', 'rejected'][rand(0, 2)],
                'approved_by' => in_array($employee->status, ['approved', 'rejected']) ? $users[1]->id : null,
                'approved_at' => in_array($employee->status, ['approved', 'rejected']) ? now() : null,
            ]);
        }

        // Payrolls (10 records)
        $payrolls = [];
        foreach (range(0, 9) as $i) {
            $employee = $employees[array_rand($employees)];
            $workedDays = rand(20, 30);
            $unpaidLeaveDays = rand(0, 5);
            $totalBonus = rand(0, 2000);
            $totalDeduction = rand(0, 1000);
            $payrolls[] = Payroll::create([
                'employee_id' => $employee->id,
                'month' => Carbon::now()->startOfMonth()->subMonths(rand(1, 6)),
                'basic_salary' => $employee->basic_salary,
                'worked_days' => $workedDays,
                'unpaid_leave_days' => $unpaidLeaveDays,
                'total_bonus' => $totalBonus,
                'total_deduction' => $totalDeduction,
                'net_salary' => ($employee->basic_salary / 30 * $workedDays) + $totalBonus - $totalDeduction,
                'status' => ['pending', 'approved'][rand(0, 1)],
                'approved_by' => ($employee->status === 'approved') ? $users[1]->id : null,
                'approved_at' => ($employee->status === 'approved') ? now() : null,
            ]);
        }

        // Payroll Bonuses (10 records)
        $payrollBonuses = [];
        foreach (range(0, 9) as $i) {
            $payroll = $payrolls[array_rand($payrolls)];
            $payrollBonuses[] = PayrollBonus::create([
                'payroll_id' => $payroll->id,
                'bonus_type_id' => $bonusTypes[array_rand($bonusTypes)]->id,
                'amount' => rand(100, 1000) + 0.00,
            ]);
        }

        // Payroll Deductions (10 records)
        $payrollDeductions = [];
        foreach (range(0, 9) as $i) {
            $payroll = $payrolls[array_rand($payrolls)];
            $payrollDeductions[] = PayrollDeduction::create([
                'payroll_id' => $payroll->id,
                'deduction_type_id' => $deductionTypes[array_rand($deductionTypes)]->id,
                'amount' => rand(100, 500) + 0.00,
            ]);
        }

        // Training Programs (10 records)
        $trainingPrograms = [];
        $trainingNames = [
            'Laravel Advanced Training', 'Leadership Skills', 'Data Analysis', 'UI/UX Design',
            'Financial Management', 'Sales Techniques', 'HR Compliance', 'Project Management',
            'Customer Service Excellence', 'DevOps Fundamentals'
        ];
        foreach ($trainingNames as $name) {
            $trainingPrograms[] = TrainingProgram::create([
                'name' => $name,
                'details' => "Details for $name training program.",
                'instructor_employee_id' => $employees[array_rand($employees)]->id,
                'available_days' => ['Mon', 'Wed', 'Fri'],
                'available_total_employees' => rand(10, 30),
                'available_time' => '4:00pm to 6:00pm',
                'status' => ['available', 'ongoing', 'completed'][rand(0, 2)],
            ]);
        }

        // Training Assignments (10 records)
        $trainingAssignments = [];
        foreach (range(0, 9) as $i) {
            $trainingAssignments[] = TrainingAssignment::create([
                'training_program_id' => $trainingPrograms[array_rand($trainingPrograms)]->id,
                'employee_id' => $employees[array_rand($employees)]->id,
                'status' => ['pending', 'enrolled', 'completed'][rand(0, 2)],
                'start_date' => Carbon::now()->startOfMonth()->addDays(rand(0, 15)),
                'end_date' => Carbon::now()->startOfMonth()->addDays(rand(16, 30)),
            ]);
        }
    }
}
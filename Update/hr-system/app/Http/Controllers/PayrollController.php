<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Leave;
use App\Models\Payroll;
use App\Models\PayrollSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Auth::user()->user_type === 'hr'
            ? Payroll::with(['employee', 'approver'])->get()
            : Payroll::where('employee_id', Auth::user()->employee_id)
                ->with(['employee', 'approver'])
                ->get();

        return view('payrolls.index', compact('payrolls'));
    }

    public function create()
    {
        if (Auth::user()->user_type !== 'hr') {
            return redirect()->route('employee.payrolls.index')->with('error', 'Unauthorized action.');
        }

        $employees = Employee::whereIn('status', ['permanent', 'contracted', 'intern'])
            ->whereNotNull('basic_salary')
            ->where('basic_salary', '>', 0)
            ->get();

        Log::info('Employees retrieved for payroll creation', [
            'count' => $employees->count(),
            'employee_ids' => $employees->pluck('id')->toArray(),
        ]);

        return view('payrolls.create', compact('employees'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->user_type !== 'hr') {
            return redirect()->route('employee.payrolls.index')->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'period_start' => 'required|date',
            'period_end' => 'required|date|after_or_equal:period_start',
            'other_deductions' => 'nullable|numeric|min:0',
        ]);

        $employee = Employee::findOrFail($request->employee_id);

        Log::info('Employee data for payroll creation', [
            'employee_id' => $employee->id,
            'basic_salary' => $employee->basic_salary,
        ]);

        if (is_null($employee->basic_salary) || $employee->basic_salary <= 0) {
            return redirect()->back()->withErrors(['employee_id' => 'Employee has no valid basic salary set (must be greater than 0).']);
        }

        $periodStart = Carbon::parse($request->period_start);
        $periodEnd = Carbon::parse($request->period_end);

        // Check for overlapping payroll periods
        $existingPayroll = Payroll::where('employee_id', $employee->id)
            ->where(function ($query) use ($periodStart, $periodEnd) {
                $query
                    ->whereBetween('period_start', [$periodStart, $periodEnd])
                    ->orWhereBetween('period_end', [$periodStart, $periodEnd])
                    ->orWhere(function ($query) use ($periodStart, $periodEnd) {
                        $query
                            ->where('period_start', '<=', $periodStart)
                            ->where('period_end', '>=', $periodEnd);
                    });
            })
            ->exists();

        if ($existingPayroll) {
            return redirect()->back()->withErrors(['period_start' => 'Payroll period overlaps with an existing payroll for this employee.']);
        }

        // Calculate leave deductions
        $leaveDeductions = 0;
        $periodDays = max($periodStart->diffInDays($periodEnd) + 1, 1);  // Prevent division by zero
        $dailySalary = $employee->basic_salary / $periodDays;  // Dynamic daily salary
        $leaves = Leave::where('employee_id', $employee->id)
            ->where('status', 'approved')
            ->where(function ($query) use ($periodStart, $periodEnd) {
                $query
                    ->whereBetween('start_date', [$periodStart, $periodEnd])
                    ->orWhereBetween('end_date', [$periodStart, $periodEnd])
                    ->orWhere(function ($query) use ($periodStart, $periodEnd) {
                        $query
                            ->where('start_date', '<=', $periodStart)
                            ->where('end_date', '>=', $periodEnd);
                    });
            })
            ->with('leaveType')
            ->get();

        foreach ($leaves as $leave) {
            if (!$leave->leaveType || $leave->leaveType->is_paid) {
                Log::warning('Skipping leave due to missing leaveType or paid leave', [
                    'leave_id' => $leave->id,
                    'leave_type_id' => $leave->leave_type_id,
                ]);
                continue;
            }
            $leaveStart = Carbon::parse($leave->start_date)->max($periodStart);
            $leaveEnd = Carbon::parse($leave->end_date)->min($periodEnd);
            $days = max($leaveStart->diffInDays($leaveEnd) + 1, 0);
            $leaveDeductions += $days * $dailySalary;
            Log::info('Leave deduction calculated', [
                'leave_id' => $leave->id,
                'days' => $days,
                'daily_salary' => $dailySalary,
                'deduction' => $days * $dailySalary,
            ]);
        }

        // Calculate tax deductions
        $taxRate = PayrollSetting::where('name', 'Tax Rate')->first()?->value ?? 0;
        $taxDeductions = ($employee->basic_salary * $taxRate) / 100;

        // Calculate net salary
        $netSalary = $employee->basic_salary - $leaveDeductions - $taxDeductions - ($request->other_deductions ?? 0);

        if ($netSalary < 0) {
            return redirect()->back()->withErrors(['other_deductions' => 'Net salary cannot be negative.']);
        }

        Payroll::create([
            'employee_id' => $employee->id,
            'period_start' => $periodStart,
            'period_end' => $periodEnd,
            'basic_salary' => $employee->basic_salary,  // Changed from base_salary
            'leave_deductions' => $leaveDeductions,
            'tax_deductions' => $taxDeductions,
            'other_deductions' => $request->other_deductions ?? 0,
            'net_salary' => $netSalary,
            'status' => 'draft',
        ]);

        return redirect()->route('hr.payrolls.index')->with('success', 'Payroll created successfully.');
    }

    public function show(Payroll $payroll)
    {
        if (Auth::user()->user_type === 'employee' && Auth::user()->employee_id !== $payroll->employee_id) {
            return redirect()->route('employee.payrolls.index')->with('error', 'Unauthorized action.');
        }

        return view('payrolls.show', compact('payroll'));
    }

    public function approve(Payroll $payroll)
    {
        if (Auth::user()->user_type !== 'hr') {
            return redirect()->route('employee.payrolls.index')->with('error', 'Unauthorized action.');
        }

        $payroll->update([
            'status' => 'approved',
            'approved_by' => Auth::user()->id,
            'approved_at' => now(),
        ]);

        return redirect()->route('hr.payrolls.index')->with('success', 'Payroll approved successfully.');
    }
}

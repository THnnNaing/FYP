<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    // app/Http/Controllers/EmployeeController.php
    public function index()
    {
        $employees = Employee::with(['department', 'designation'])->paginate(5);
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $departments = Department::all();
        $designations = Designation::all();
        return view('employees.create', compact('departments', 'designations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required|date|before:today',
            'address' => 'required|string',
            'nrc' => ['required', 'string', 'regex:/^\d{1,2}\/[A-Z]{3}\d{6}$/', 'unique:employees,nrc'],
            'phonenumber' => 'required|string|max:20|unique:employees,phonenumber',
            'email' => 'required|email|unique:employees,email',
            'status' => ['required', Rule::in(['permanent', 'contracted', 'training', 'intern'])],
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
            'basic_salary' => 'required|numeric|min:0',
        ]);

        Employee::create($request->all());
        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function edit(Employee $employee)
    {
        if (Auth::user()->user_type === 'employee' && Auth::user()->employee_id !== $employee->id) {
            return redirect()->route('employee.dashboard')->with('error', 'Unauthorized action.');
        }

        $departments = Department::all();
        $designations = Designation::all();
        return view('employees.edit', compact('employee', 'departments', 'designations'));
    }

    public function update(Request $request, Employee $employee)
    {
        if (Auth::user()->user_type === 'employee' && Auth::user()->employee_id !== $employee->id) {
            return redirect()->route('employee.dashboard')->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required|date|before:today',
            'address' => 'required|string',
            'nrc' => ['required', 'string', 'regex:/^\d{1,2}\/[A-Z]{3}\d{6}$/', Rule::unique('employees')->ignore($employee->id)],
            'phonenumber' => ['required', 'string', 'max:20', Rule::unique('employees')->ignore($employee->id)],
            'email' => ['required', 'email', Rule::unique('employees')->ignore($employee->id)],
            'status' => ['required', Rule::in(['permanent', 'contracted', 'training', 'intern'])],
            'department_id' => 'required|exists:departments,id',
            'designation_id' => 'required|exists:designations,id',
            'basic_salary' => 'required|numeric|min:0',
        ]);

        $employee->update($request->all());
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    public function show(Employee $employee)
    {
        if (Auth::user()->user_type === 'employee' && Auth::user()->employee_id !== $employee->id) {
            return redirect()->route('employee.dashboard')->with('error', 'Unauthorized action.');
        }

        return view('employees.show', compact('employee'));
    }

    public function dashboard()
    {
        $employee = Auth::user()->employee;
        return view('employee.dashboard', compact('employee'));
    }
}

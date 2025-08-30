@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary mb-4">Generate Payroll</h1>
    <div class="card bg-white p-3">
        <div class="card-body">
            @if($employees->isEmpty())
                <div class="alert alert-warning">
                    No eligible employees available to generate payrolls. Please ensure employees have an active status and a valid basic salary.
                    <a href="{{ route('hr.employees.create') }}" class="btn btn-primary btn-sm mt-2">Create Employee</a>
                    <a href="{{ route('hr.employees.index') }}" class="btn btn-secondary btn-sm mt-2">Manage Employees</a>
                </div>
            @else
                <form action="{{ route('hr.payrolls.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="employee_id" class="form-label">Employee</label>
                        <select name="employee_id" class="form-control" required>
                            <option value="" disabled selected>Select an employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->first_name }} {{ $employee->last_name }} ({{ $employee->status }}) - Salary: {{ number_format($employee->basic_salary, 2) }}
                                </option>
                            @endforeach
                        </select>
                        @error('employee_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="period_start" class="form-label">Period Start</label>
                        <input type="date" name="period_start" class="form-control" value="{{ old('period_start') }}" required>
                        @error('period_start') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="period_end" class="form-label">Period End</label>
                        <input type="date" name="period_end" class="form-control" value="{{ old('period_end') }}" required>
                        @error('period_end') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="other_deductions" class="form-label">Other Deductions (Optional)</label>
                        <input type="number" step="0.01" name="other_deductions" class="form-control" value="{{ old('other_deductions', 0) }}">
                        @error('other_deductions') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Generate</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
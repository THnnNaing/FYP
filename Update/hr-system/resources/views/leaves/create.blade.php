<!-- resources/views/leaves/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary mb-4">Request Leave</h1>
    <div class="card bg-white p-3">
        <div class="card-body">
            <form action="{{ route('leaves.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="employee_id" class="form-label">Employee</label>
                    <select name="employee_id" class="form-control" {{ auth()->user()->user_type === 'employee' ? 'disabled' : '' }} required>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ auth()->user()->employee_id == $employee->id ? 'selected' : '' }}>
                                {{ $employee->first_name }} {{ $employee->last_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('employee_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="leave_type_id" class="form-label">Leave Type</label>
                    <select name="leave_type_id" class="form-control" required>
                        @foreach($leaveTypes as $leaveType)
                            <option value="{{ $leaveType->id }}" {{ old('leave_type_id') == $leaveType->id ? 'selected' : '' }}>
                                {{ $leaveType->name }} ({{ $leaveType->is_paid ? 'Paid' : 'Unpaid' }})
                            </option>
                        @endforeach
                    </select>
                    @error('leave_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
                    @error('start_date') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
                    @error('end_date') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="reason" class="form-label">Reason (Optional)</label>
                    <textarea name="reason" class="form-control">{{ old('reason') }}</textarea>
                    @error('reason') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
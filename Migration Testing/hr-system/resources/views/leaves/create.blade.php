@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary mb-4">Request Leave</h1>
    <div class="card p-3">
        <div class="card-body">
            <form action="{{ route(auth()->user()->user_type === 'hr' ? 'hr.leaves.store' : 'employee.leaves.store') }}" method="POST">
                @csrf
                <div class="mb-3 position-relative">
                    <label for="employee_search" class="form-label">Employee</label>
                    @if(auth()->user()->user_type === 'hr')
                        <input type="text" id="employee_search" class="form-control search-box" placeholder="Type employee name..." autocomplete="off">
                        <input type="hidden" name="employee_id" id="employee_id" value="{{ old('employee_id') }}" required>
                        <div id="employee_suggestions" class="suggestions-dropdown" style="display: none;"></div>
                        @if($employees->isEmpty())
                            <span class="text-danger mt-2 d-block">No active employees found. Please add employees in the HR dashboard.</span>
                        @endif
                    @else
                        <input type="text" class="form-control" value="{{ auth()->user()->employee ? auth()->user()->employee->first_name . ' ' . auth()->user()->employee->last_name : '' }}" disabled>
                        <input type="hidden" name="employee_id" value="{{ auth()->user()->employee_id }}">
                    @endif
                    @error('employee_id') <span class="text-danger mt-2 d-block">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="leave_type_id" class="form-label">Leave Type</label>
                    <select name="leave_type_id" class="form-control" required>
                        <option value="" disabled selected>Select a leave type</option>
                        @foreach($leaveTypes as $leaveType)
                            <option value="{{ $leaveType->id }}" {{ old('leave_type_id') == $leaveType->id ? 'selected' : '' }}>
                                {{ $leaveType->name }} ({{ $leaveType->is_paid ? 'Paid' : 'Unpaid' }})
                            </option>
                        @endforeach
                    </select>
                    @error('leave_type_id') <span class="text-danger mt-2 d-block">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
                    @error('start_date') <span class="text-danger mt-2 d-block">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
                    @error('end_date') <span class="text-danger mt-2 d-block">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="reason" class="form-label">Reason (Optional)</label>
                    <textarea name="reason" class="form-control">{{ old('reason') }}</textarea>
                    @error('reason') <span class="text-danger mt-2 d-block">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
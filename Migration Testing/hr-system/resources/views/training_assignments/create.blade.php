@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary mb-4">Assign Employee to Training Program</h1>
    <div class="card bg-white p-3">
        <div class="card-body">
            <form action="{{ route('hr.training_assignments.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="training_program_id" class="form-label">Training Program</label>
                    <select name="training_program_id" class="form-control" required>
                        <option value="">Select Program</option>
                        @foreach($programs as $program)
                            <option value="{{ $program->id }}">{{ $program->name }} ({{ $program->instructor->first_name }} {{ $program->instructor->last_name }})</option>
                        @endforeach
                    </select>
                    @error('training_program_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="employee_id" class="form-label">Employee</label>
                    <select name="employee_id" class="form-control" required>
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                        @endforeach
                    </select>
                    @error('employee_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="started" {{ old('status') == 'started' ? 'selected' : '' }}>Started</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status') <span class="text-danger">{{ $message }}</span> @enderror
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
                <button type="submit" class="btn btn-primary">Assign</button>
            </form>
        </div>
    </div>
</div>
@endsection
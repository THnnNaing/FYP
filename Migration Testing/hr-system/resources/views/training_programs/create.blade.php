@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary mb-4">Create Training Program</h1>
    <div class="card bg-white p-3">
        <div class="card-body">
            <form action="{{ route('training_programs.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Program Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="details" class="form-label">Details (Optional)</label>
                    <textarea name="details" class="form-control">{{ old('details') }}</textarea>
                    @error('details') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="instructor_employee_id" class="form-label">Instructor</label>
                    <select name="instructor_employee_id" class="form-control" required>
                        <option value="">Select Instructor</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                        @endforeach
                    </select>
                    @error('instructor_employee_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="available_days" class="form-label">Available Days</label>
                    <select name="available_days[]" class="form-control" multiple required>
                        @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                            <option value="{{ $day }}" {{ in_array($day, old('available_days', [])) ? 'selected' : '' }}>{{ $day }}</option>
                        @endforeach
                    </select>
                    @error('available_days') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="available_total_employees" class="form-label">Total Employees</label>
                    <input type="number" name="available_total_employees" class="form-control" value="{{ old('available_total_employees') }}" min="1" required>
                    @error('available_total_employees') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="available_time" class="form-label">Available Time</label>
                    <input type="text" name="available_time" class="form-control" value="{{ old('available_time') }}" placeholder="e.g., 4:00pm to 6:00pm" required>
                    @error('available_time') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="ended" {{ old('status') == 'ended' ? 'selected' : '' }}>Ended</option>
                    </select>
                    @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary mb-4">Add Employee</h1>
    <div class="card bg-white p-3">
        <div class="card-body">
            <form action="{{ route('employees.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                            @error('first_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                            @error('last_name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" name="dob" class="form-control" value="{{ old('dob') }}" required>
                    @error('dob') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea name="address" class="form-control" required>{{ old('address') }}</textarea>
                    @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="nrc" class="form-label">NRC (e.g., 12/ABC123456)</label>
                    <input type="text" name="nrc" class="form-control" value="{{ old('nrc') }}" required>
                    @error('nrc') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="phonenumber" class="form-label">Phone Number</label>
                    <input type="text" name="phonenumber" class="form-control" value="{{ old('phonenumber') }}" required>
                    @error('phonenumber') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="basic_salary" class="form-label">Basic Salary</label>
                    <input type="number" name="basic_salary" class="form-control" value="{{ old('basic_salary') }}" step="0.01" required>
                    @error('basic_salary') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="permanent" {{ old('status') == 'permanent' ? 'selected' : '' }}>Permanent</option>
                        <option value="contracted" {{ old('status') == 'contracted' ? 'selected' : '' }}>Contracted</option>
                        <option value="training" {{ old('status') == 'training' ? 'selected' : '' }}>Training</option>
                        <option value="intern" {{ old('status') == 'intern' ? 'selected' : '' }}>Intern</option>
                    </select>
                    @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="department_id" class="form-label">Department</label>
                    <select name="department_id" class="form-control" required>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                        @endforeach
                    </select>
                    @error('department_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="designation_id" class="form-label">Designation</label>
                    <select name="designation_id" class="form-control" required>
                        @foreach($designations as $designation)
                            <option value="{{ $designation->id }}" {{ old('designation_id') == $designation->id ? 'selected' : '' }}>{{ $designation->title }}</option>
                        @endforeach
                    </select>
                    @error('designation_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection
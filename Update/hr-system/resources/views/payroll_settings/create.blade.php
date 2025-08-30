@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary mb-4">Add Payroll Setting</h1>
    <div class="card bg-white p-3">
        <div class="card-body">
            <form action="{{ route('payroll_settings.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Setting Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="value" class="form-label">Value (e.g., 15.00 for 15% tax)</label>
                    <input type="number" step="0.01" name="value" class="form-control" value="{{ old('value') }}" required>
                    @error('value') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection
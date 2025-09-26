@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary mb-4">Add Leave Type</h1>
    <div class="card bg-white p-3">
        <div class="card-body">
            <form action="{{ route('leave_types.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Leave Type Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="is_paid" class="form-label">Paid/Unpaid</label>
                    <select name="is_paid" class="form-control" required>
                        <option value="1" {{ old('is_paid') == '1' ? 'selected' : '' }}>Paid</option>
                        <option value="0" {{ old('is_paid') == '0' ? 'selected' : '' }}>Unpaid</option>
                    </select>
                    @error('is_paid') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection
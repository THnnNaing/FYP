@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary mb-4">Edit Leave Type</h1>
    <div class="card bg-white p-3">
        <div class="card-body">
            <form action="{{ route('leave_types.update', $leaveType) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Leave Type Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $leaveType->name }}" required>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="is_paid" class="form-label">Paid/Unpaid</label>
                    <select name="is_paid" class="form-control" required>
                        <option value="1" {{ $leaveType->is_paid ? 'selected' : '' }}>Paid</option>
                        <option value="0" {{ $leaveType->is_paid ? '' : 'selected' }}>Unpaid</option>
                    </select>
                    @error('is_paid') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
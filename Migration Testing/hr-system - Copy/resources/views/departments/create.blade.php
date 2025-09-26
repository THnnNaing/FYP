@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary mb-4">Add Department</h1>
    <div class="card bg-white p-3">
        <div class="card-body">
            <form action="{{ route('departments.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Department Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
@endsection
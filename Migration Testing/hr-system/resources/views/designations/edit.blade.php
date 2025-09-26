@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary mb-4">Edit Designation</h1>
    <div class="card bg-white p-3">
        <div class="card-body">
            <form action="{{ route('designations.update', $designation) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="title" class="form-label">Designation Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $designation->title }}" required>
                    @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
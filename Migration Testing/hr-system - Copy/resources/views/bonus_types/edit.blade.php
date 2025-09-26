@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary mb-4">Edit Bonus Type</h1>
    <div class="card bg-white p-3">
        <div class="card-body">
            <form action="{{ route('bonus_types.update', $bonusType) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Bonus Type Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $bonusType->name }}" required>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description (Optional)</label>
                    <textarea name="description" class="form-control">{{ $bonusType->description }}</textarea>
                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
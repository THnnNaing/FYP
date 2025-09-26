@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary mb-4">Bonus Types</h1>
    <a href="{{ route('bonus_types.create') }}" class="btn btn-primary mb-3">Add Bonus Type</a>
    <div class="card bg-white">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bonusTypes as $bonusType)
                        <tr>
                            <td>{{ $bonusType->name }}</td>
                            <td>{{ $bonusType->description ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('bonus_types.edit', $bonusType) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('bonus_types.destroy', $bonusType) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
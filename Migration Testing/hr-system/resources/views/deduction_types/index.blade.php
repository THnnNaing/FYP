@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary mb-4">Deduction Types</h1>
    <a href="{{ route('deduction_types.create') }}" class="btn btn-primary mb-3">Add Deduction Type</a>
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
                    @foreach($deductionTypes as $deductionType)
                        <tr>
                            <td>{{ $deductionType->name }}</td>
                            <td>{{ $deductionType->description ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('deduction_types.edit', $deductionType) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('deduction_types.destroy', $deductionType) }}" method="POST" style="display:inline;">
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
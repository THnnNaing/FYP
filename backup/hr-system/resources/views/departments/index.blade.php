@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary mb-4">Departments</h1>
    <a href="{{ route('departments.create') }}" class="btn btn-primary mb-3">Add Department</a>
    <div class="card bg-white">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($departments as $department)
                        <tr>
                            <td>{{ $department->name }}</td>
                            <td>
                                <a href="{{ route('departments.edit', $department) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('departments.destroy', $department) }}" method="POST" style="display:inline;">
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
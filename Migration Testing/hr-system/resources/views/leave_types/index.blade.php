@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary mb-4">Leave Types</h1>
    <a href="{{ route('leave_types.create') }}" class="btn btn-primary mb-3">Add Leave Type</a>
    <div class="card bg-white">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Paid/Unpaid</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leaveTypes as $leaveType)
                        <tr>
                            <td>{{ $leaveType->name }}</td>
                            <td>{{ $leaveType->is_paid ? 'Paid' : 'Unpaid' }}</td>
                            <td>
                                <a href="{{ route('leave_types.edit', $leaveType) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('leave_types.destroy', $leaveType) }}" method="POST" style="display:inline;">
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
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary mb-4">Training Programs</h1>
    <a href="{{ route('training_programs.create') }}" class="btn btn-primary mb-3">Create Training Program</a>
    <div class="card bg-white">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Instructor</th>
                        <th>Available Days</th>
                        <th>Available Time</th>
                        <th>Total Employees</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($programs as $program)
                        <tr>
                            <td>{{ $program->name }}</td>
                            <td>{{ $program->instructor->first_name }} {{ $program->instructor->last_name }}</td>
                            <td>{{ implode(', ', $program->available_days) }}</td>
                            <td>{{ $program->available_time }}</td>
                            <td>{{ $program->available_total_employees }}</td>
                            <td>{{ ucfirst($program->status) }}</td>
                            <td>
                                <a href="{{ route('training_programs.edit', $program) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('training_programs.destroy', $program) }}" method="POST" style="display:inline;">
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
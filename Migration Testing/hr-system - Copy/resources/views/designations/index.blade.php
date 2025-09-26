@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary mb-4">Designations</h1>
    <a href="{{ route('designations.create') }}" class="btn btn-primary mb-3">Add Designation</a>
    <div class="card bg-white">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($designations as $designation)
                        <tr>
                            <td>{{ $designation->title }}</td>
                            <td>
                                <a href="{{ route('designations.edit', $designation) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('designations.destroy', $designation) }}" method="POST" style="display:inline;">
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
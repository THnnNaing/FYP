@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary mb-4">HR Dashboard</h1>
    <div class="card bg-white p-3">
        <div class="card-body">
            <h5 class="card-title text-primary">Manage Employees</h5>
            <p class="card-text">Add, view, or update employee records.</p>
            <a href="{{ route('hr.employees.index') }}" class="btn btn-primary">Go to Employees</a>

        </div>
    </div>
</div>
@endsection
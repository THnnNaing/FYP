@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-dark fw-bold">Admin Dashboard</h1>
        <div class="text-muted">Welcome back, {{ Auth::user()->name }}</div>
    </div>
    
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                            <i class="bi bi-people-fill text-primary fs-4"></i>
                        </div>
                        <h5 class="card-title mb-0 fw-bold">Manage Employees</h5>
                    </div>
                    <p class="card-text text-muted mb-4">View, add, edit, or delete employee records.</p>
                    <a href="{{ route('employees.index') }}" class="btn btn-primary px-4">
                        Go to Employees
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                            <i class="bi bi-building text-primary fs-4"></i>
                        </div>
                        <h5 class="card-title mb-0 fw-bold">Manage Departments</h5>
                    </div>
                    <p class="card-text text-muted mb-4">Organize departments for your organization.</p>
                    <a href="{{ route('departments.index') }}" class="btn btn-primary px-4">
                        Go to Departments
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                            <i class="bi bi-person-badge text-primary fs-4"></i>
                        </div>
                        <h5 class="card-title mb-0 fw-bold">Manage Designations</h5>
                    </div>
                    <p class="card-text text-muted mb-4">Create and manage job titles.</p>
                    <a href="{{ route('designations.index') }}" class="btn btn-primary px-4">
                        Go to Designations
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
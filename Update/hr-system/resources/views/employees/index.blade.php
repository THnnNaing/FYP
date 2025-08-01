@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <h1 class="text-dark fw-bold mb-2 mb-md-0">Employees</h1>
        @if(auth()->user()->user_type === 'admin' || auth()->user()->user_type === 'hr')
            <a href="{{ route('employees.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i> <span>Add Employee</span>
            </a>
        @endif
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 text-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Name</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                            <tr>
                                <td class="ps-4">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                                <td>{{ $employee->email }}</td>
                                <td>{{ $employee->department->name }}</td>
                                <td>{{ $employee->designation->title }}</td>
                                <td>
                                    <span class="badge rounded-pill text-capitalize
                                        @if($employee->status === 'active') bg-success
                                        @elseif($employee->status === 'on_leave') bg-warning text-dark
                                        @elseif($employee->status === 'terminated') bg-danger
                                        @else bg-secondary
                                        @endif">
                                        {{ str_replace('_', ' ', $employee->status) }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex flex-wrap gap-2 justify-content-end">
                                        <a href="{{ route('employees.show', $employee) }}" 
                                           class="btn btn-sm btn-outline-info d-flex align-items-center gap-1">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                        @if(auth()->user()->user_type !== 'employee' || auth()->user()->employee_id === $employee->id)
                                            <a href="{{ route('employees.edit', $employee) }}" 
                                               class="btn btn-sm btn-outline-warning d-flex align-items-center gap-1">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                        @endif
                                        @if(auth()->user()->user_type === 'admin')
                                            <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1"
                                                        onclick="return confirm('Are you sure you want to delete this employee?')">
                                                    <i class="bi bi-trash3"></i> Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .table thead th {
        padding: 12px 16px;
        font-weight: 600;
        background-color: #f8f9fa;
        white-space: nowrap;
    }

    .table tbody td {
        padding: 12px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
        white-space: nowrap;
    }

    .table tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.03);
    }

    .btn-sm i {
        font-size: 0.85rem;
    }

    .badge {
        font-size: 0.8rem;
        padding: 0.4em 0.75em;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.9rem;
        }

        .table thead {
            display: none;
        }

        .table tbody td {
            display: flex;
            justify-content: space-between;
            padding: 8px 12px;
            border-bottom: 1px solid #dee2e6;
        }

        .table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #495057;
        }

        .table tbody tr td:first-child {
            font-weight: bold;
        }
    }
</style>
@endsection

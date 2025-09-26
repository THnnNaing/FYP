@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <h1 class="text-dark fw-bold mb-2 mb-md-0">Payrolls</h1>
        <div>
            @if(auth()->user()->user_type === 'hr')
                <a href="{{ route('hr.payrolls.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                    <i class="bi bi-plus-lg"></i> <span>Create Payroll</span>
                </a>
            @endif
            @if(auth()->user()->user_type === 'employee' && auth()->user()->employee->status === 'permanent')
                <form action="{{ route('employee.payrolls.request') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary d-flex align-items-center gap-2 ms-2">
                        <i class="bi bi-plus-lg"></i> <span>Request Payroll</span>
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 text-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Employee</th>
                            <th>Month</th>
                            <th>Basic Salary</th>
                            <th>Worked Days</th>
                            <th>Unpaid Leave Days</th>
                            <th>Total Bonus</th>
                            <th>Total Deduction</th>
                            <th>Net Salary</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payrolls as $payroll)
                            <tr>
                                <td class="ps-4">{{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}</td>
                                <td>{{ $payroll->month->format('Y-m') }}</td>
                                <td>{{ number_format($payroll->basic_salary, 2) }}</td>
                                <td>{{ $payroll->worked_days ?? 'N/A' }}</td>
                                <td>{{ $payroll->unpaid_leave_days }}</td>
                                <td>{{ number_format($payroll->total_bonus, 2) }}</td>
                                <td>{{ number_format($payroll->total_deduction, 2) }}</td>
                                <td>{{ number_format($payroll->net_salary, 2) }}</td>
                                <td>
                                    <span class="badge rounded-pill text-capitalize
                                        @if($payroll->status === 'approved') bg-success
                                        @elseif($payroll->status === 'pending') bg-warning text-dark
                                        @elseif($payroll->status === 'rejected') bg-danger
                                        @else bg-secondary
                                        @endif">
                                        {{ $payroll->status }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex flex-wrap gap-2 justify-content-end">
                                        <a href="{{ route('hr.payrolls.show', $payroll) }}" 
                                           class="btn btn-sm btn-outline-info d-flex align-items-center gap-1">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                        @if(auth()->user()->user_type === 'hr' && $payroll->status === 'pending')
                                            <form action="{{ route('hr.payrolls.approve', $payroll) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-success d-flex align-items-center gap-1">
                                                    <i class="bi bi-check-lg"></i> Approve
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
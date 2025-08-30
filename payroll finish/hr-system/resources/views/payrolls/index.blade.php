@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary mb-4">{{ auth()->user()->user_type === 'hr' ? 'Payrolls' : 'My Payrolls' }}</h1>
    @if(auth()->user()->user_type === 'hr')
        <a href="{{ route('hr.payrolls.create') }}" class="btn btn-primary mb-3">Generate Payroll</a>
    @endif
    <div class="card bg-white">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        @if(auth()->user()->user_type === 'hr')
                            <th>Employee</th>
                        @endif
                        <th>Period</th>
                        <th>Net Salary</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payrolls as $payroll)
                        <tr>
                            @if(auth()->user()->user_type === 'hr')
                                <td>{{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}</td>
                            @endif
                            <td>{{ $payroll->period_start->format('Y-m-d') }} to {{ $payroll->period_end->format('Y-m-d') }}</td>
                            <td>{{ number_format($payroll->net_salary, 2) }}</td>
                            <td>{{ ucfirst($payroll->status) }}</td>
                            <td>
                                <a href="{{ route(auth()->user()->user_type === 'hr' ? 'hr.payrolls.show' : 'employee.payrolls.show', $payroll) }}" class="btn btn-info btn-sm">View</a>
                                @if(auth()->user()->user_type === 'hr' && $payroll->status === 'draft')
                                    <form action="{{ route('hr.payrolls.approve', $payroll) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
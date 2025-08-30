@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary mb-4">Payroll Details</h1>
    <div class="card bg-white p-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    @if(auth()->user()->user_type === 'hr')
                        <p><strong>Employee:</strong> {{ $payroll->employee->first_name }} {{ $payroll->employee->last_name }}</p>
                    @endif
                    <p><strong>Period:</strong> {{ $payroll->period_start->format('Y-m-d') }} to {{ $payroll->period_end->format('Y-m-d') }}</p>
                    <p><strong>Base Salary:</strong> {{ number_format($payroll->base_salary, 2) }}</p>
                    <p><strong>Leave Deductions:</strong> {{ number_format($payroll->leave_deductions, 2) }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Tax Deductions:</strong> {{ number_format($payroll->tax_deductions, 2) }}</p>
                    <p><strong>Other Deductions:</strong> {{ number_format($payroll->other_deductions, 2) }}</p>
                    <p><strong>Net Salary:</strong> {{ number_format($payroll->net_salary, 2) }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($payroll->status) }}</p>
                    @if(auth()->user()->user_type === 'hr')
                        <p><strong>Approved By:</strong> {{ $payroll->approver ? $payroll->approver->name : 'N/A' }}</p>
                        <p><strong>Approved At:</strong> {{ $payroll->approved_at ? $payroll->approved_at->format('Y-m-d H:i') : 'N/A' }}</p>
                    @endif
                </div>
            </div>
            @if(auth()->user()->user_type === 'hr' && $payroll->status === 'draft')
                <div class="mt-3">
                    <form action="{{ route('hr.payrolls.approve', $payroll) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-success">Approve</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
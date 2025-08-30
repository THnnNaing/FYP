@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary mb-4">Leave Requests</h1>
    @if(auth()->user()->user_type === 'hr')
        <a href="{{ route('hr.leaves.create') }}" class="btn btn-primary mb-3">Request Leave</a>
    @elseif(auth()->user()->user_type === 'employee')
        <a href="{{ route('employee.leaves.create') }}" class="btn btn-primary mb-3">Request Leave</a>
    @endif

    <div class="card bg-white">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Leave Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leaves as $leave)
                        <tr>
                            <td>{{ $leave->employee->first_name }} {{ $leave->employee->last_name }}</td>
                            <td>{{ $leave->leaveType->name }} ({{ $leave->leaveType->is_paid ? 'Paid' : 'Unpaid' }})</td>
                            <td>{{ $leave->start_date->format('Y-m-d') }}</td>
                            <td>{{ $leave->end_date->format('Y-m-d') }}</td>
                            <td>
                                <span class="badge 
                                    @if($leave->status === 'approved') bg-success 
                                    @elseif($leave->status === 'declined') bg-danger 
                                    @else bg-warning text-dark @endif">
                                    {{ ucfirst($leave->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ 
                                    auth()->user()->user_type === 'hr' 
                                        ? route('hr.leaves.show', $leave) 
                                        : route('employee.leaves.show', $leave) 
                                }}" class="btn btn-info btn-sm">View</a>

                                @if(auth()->user()->user_type === 'hr' && $leave->status === 'pending')
                                    <form action="{{ route('hr.leaves.approve', $leave) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                    <form action="{{ route('hr.leaves.decline', $leave) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Decline</button>
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
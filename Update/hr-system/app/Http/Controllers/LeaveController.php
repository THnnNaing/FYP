<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Employee;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     * Display a listing of leaves based on user role
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->user_type === 'hr') {
            $leaves = Leave::with(['employee', 'leaveType'])->latest()->get();
            return view('leaves.index', [
                'leaves' => $leaves,
                'isHrView' => true
            ]);
        }

        // Employee view
        if (!$user->employee) {
            return redirect()->route('dashboard')
                ->with('error', 'No employee profile linked to your account.');
        }

        $leaves = Leave::where('employee_id', $user->employee_id)
                      ->with(['employee', 'leaveType'])
                      ->latest()
                      ->get();

        return view('leaves.index', [
            'leaves' => $leaves,
            'isHrView' => false
        ]);
    }

    /**
     * Show the form for creating a new leave request
     */
    public function create()
    {
        $user = Auth::user();
        $leaveTypes = LeaveType::all();

        if ($user->user_type === 'hr') {
            $employees = Employee::active()->get();
            return view('leaves.create', [
                'leaveTypes' => $leaveTypes,
                'employees' => $employees,
                'isHrView' => true
            ]);
        }

        // Employee view
        if (!$user->employee) {
            return redirect()->route('dashboard')
                ->with('error', 'No employee profile linked to your account.');
        }

        return view('leaves.create', [
            'leaveTypes' => $leaveTypes,
            'employees' => collect([$user->employee]),
            'isHrView' => false
        ]);
    }

    /**
     * Store a newly created leave request
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string|max:1000',
        ]);

        // Employees can only create leaves for themselves
        if ($user->user_type === 'employee' && $user->employee_id != $request->employee_id) {
            return back()->with('error', 'You can only create leave requests for yourself.');
        }

        Leave::create($validated);

        $redirectRoute = $user->user_type === 'hr' 
            ? 'hr.leaves.index' 
            : 'employee.leaves.index';

        return redirect()->route($redirectRoute)
            ->with('success', 'Leave request submitted successfully.');
    }

    /**
     * Display the specified leave request
     */
    public function show(Leave $leave)
    {
        $user = Auth::user();
        
        // HR can view any leave
        if ($user->user_type !== 'hr') {
            // Employees can only view their own leaves
            if ($user->employee_id !== $leave->employee_id) {
                abort(403, 'Unauthorized action.');
            }
        }

        return view('leaves.show', [
            'leave' => $leave,
            'isHrView' => $user->user_type === 'hr'
        ]);
    }

    /**
     * Approve a leave request (HR only)
     */
    public function approve(Leave $leave)
    {
        $this->authorize('approve', $leave);

        $leave->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('hr.leaves.index')
            ->with('success', 'Leave approved successfully.');
    }

    /**
     * Decline a leave request (HR only)
     */
    public function decline(Leave $leave)
    {
        $this->authorize('approve', $leave);

        $leave->update([
            'status' => 'declined',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('hr.leaves.index')
            ->with('success', 'Leave declined successfully.');
    }

    /**
     * Policy authorization for leave approval/decline
     */
    protected function authorize($ability, $leave)
    {
        if (Auth::user()->user_type !== 'hr') {
            abort(403, 'Only HR staff can approve/decline leave requests.');
        }

        if ($leave->status !== 'pending') {
            abort(400, 'Only pending leaves can be modified.');
        }
    }
}
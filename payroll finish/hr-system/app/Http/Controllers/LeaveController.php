<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Employee;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LeaveController extends Controller
{
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

        if (!$user->employee_id) {
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

    public function create()
    {
        $user = Auth::user();
        $leaveTypes = LeaveType::all();

        if ($user->user_type === 'hr') {
            $employees = Employee::active()->get();
            if ($employees->isEmpty()) {
                Log::warning('No active employees found for HR leave creation.');
                // Fallback to all employees if none are active (for debugging)
                $employees = Employee::all();
                if ($employees->isEmpty()) {
                    return redirect()->route('hr.leaves.index')
                        ->with('error', 'No employees found in the system.');
                }
            }
            return view('leaves.create', [
                'leaveTypes' => $leaveTypes,
                'employees' => $employees,
                'isHrView' => true
            ]);
        }

        if (!$user->employee_id) {
            return redirect()->route('dashboard')
                ->with('error', 'No employee profile linked to your account.');
        }

        return view('leaves.create', [
            'leaveTypes' => $leaveTypes,
            'employees' => collect([$user->employee]),
            'isHrView' => false
        ]);
    }

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

        if ($user->user_type === 'employee' && $user->employee_id != $request->employee_id) {
            return back()->with('error', 'You can only create leave requests for yourself.');
        }

        // Check for overlapping leave requests
        $overlappingLeave = Leave::where('employee_id', $request->employee_id)
            ->where('status', '!=', 'declined')
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                    ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('start_date', '<=', $request->start_date)
                            ->where('end_date', '>=', $request->end_date);
                    });
            })->exists();

        if ($overlappingLeave) {
            return back()->withErrors(['start_date' => 'This leave request overlaps with an existing leave.']);
        }

        Leave::create($validated);

        $redirectRoute = $user->user_type === 'hr'
            ? 'hr.leaves.index'
            : 'employee.leaves.index';

        return redirect()->route($redirectRoute)
            ->with('success', 'Leave request submitted successfully.');
    }

    public function show(Leave $leave)
    {
        $user = Auth::user();

        if ($user->user_type !== 'hr' && $user->employee_id !== $leave->employee_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('leaves.show', [
            'leave' => $leave,
            'isHrView' => $user->user_type === 'hr'
        ]);
    }

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

    protected function authorize($ability, $leave)
    {
        if (Auth::user()->user_type !== 'hr') {
            abort(403, 'Only HR staff can approve/decline leave requests.');
        }

        if ($leave->status !== 'pending') {
            abort(400, 'Only pending leaves can be modified.');
        }
    }

    public function searchEmployees(Request $request)
    {
        if (Auth::user()->user_type !== 'hr') {
            abort(403, 'Unauthorized action.');
        }

        $query = $request->input('q');
        $employees = Employee::active()
            ->where(function ($q) use ($query) {
                $q->where('first_name', 'like', "%{$query}%")
                    ->orWhere('last_name', 'like', "%{$query}%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$query}%"]);
            })
            ->get(['id', 'first_name', 'last_name'])
            ->map(function ($employee) {
                return [
                    'id' => $employee->id,
                    'text' => $employee->first_name . ' ' . $employee->last_name
                ];
            });

        return response()->json($employees);
    }
}

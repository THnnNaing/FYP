<?php

namespace App\Http\Controllers;

use App\Models\TrainingProgram;
use App\Models\Employee;
use Illuminate\Http\Request;

class TrainingProgramController extends Controller
{
    public function index()
    {
        $programs = TrainingProgram::with('instructor')->get();
        return view('training_programs.index', compact('programs'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'permanent')->get();
        return view('training_programs.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'nullable|string',
            'instructor_employee_id' => 'required|exists:employees,id',
            'available_days' => 'required|array',
            'available_days.*' => 'in:Mon,Tue,Wed,Thu,Fri,Sat,Sun',
            'available_total_employees' => 'required|integer|min:1',
            'available_time' => 'required|string|max:255',
            'status' => 'required|in:available,active,ended',
        ]);

        TrainingProgram::create($request->all());

        return redirect()->route('training_programs.index')->with('success', 'Training program created successfully.');
    }

    public function edit(TrainingProgram $trainingProgram)
    {
        $employees = Employee::where('status', 'permanent')->get();
        return view('training_programs.edit', compact('trainingProgram', 'employees'));
    }

    public function update(Request $request, TrainingProgram $trainingProgram)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'nullable|string',
            'instructor_employee_id' => 'required|exists:employees,id',
            'available_days' => 'required|array',
            'available_days.*' => 'in:Mon,Tue,Wed,Thu,Fri,Sat,Sun',
            'available_total_employees' => 'required|integer|min:1',
            'available_time' => 'required|string|max:255',
            'status' => 'required|in:available,active,ended',
        ]);

        $trainingProgram->update($request->all());

        return redirect()->route('training_programs.index')->with('success', 'Training program updated successfully.');
    }

    public function destroy(TrainingProgram $trainingProgram)
    {
        $trainingProgram->delete();
        return redirect()->route('training_programs.index')->with('success', 'Training program deleted successfully.');
    }
}
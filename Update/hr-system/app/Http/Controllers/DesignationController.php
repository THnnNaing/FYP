<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DesignationController extends Controller
{
    public function index()
    {
        $designations = Designation::all();
        return view('designations.index', compact('designations'));
    }

    public function create()
    {
        return view('designations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:designations,title',
        ]);

        Designation::create($request->all());
        return redirect()->route('designations.index')->with('success', 'Designation created successfully.');
    }

    public function edit(Designation $designation)
    {
        return view('designations.edit', compact('designation'));
    }

    public function update(Request $request, Designation $designation)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255', Rule::unique('designations')->ignore($designation->id)],
        ]);

        $designation->update($request->all());
        return redirect()->route('designations.index')->with('success', 'Designation updated successfully.');
    }

    public function destroy(Designation $designation)
    {
        $designation->delete();
        return redirect()->route('designations.index')->with('success', 'Designation deleted successfully.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\PayrollSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayrollSettingController extends Controller
{
    public function index()
    {
        $settings = PayrollSetting::all();
        return view('payroll_settings.index', compact('settings'));
    }

    public function create()
    {
        return view('payroll_settings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:payroll_settings',
            'value' => 'required|numeric|min:0',
        ]);

        PayrollSetting::create($request->only(['name', 'value']));

        return redirect()->route('payroll_settings.index')->with('success', 'Payroll setting created successfully.');
    }

    public function edit(PayrollSetting $payrollSetting)
    {
        return view('payroll_settings.edit', compact('payrollSetting'));
    }

    public function update(Request $request, PayrollSetting $payrollSetting)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:payroll_settings,name,' . $payrollSetting->id,
            'value' => 'required|numeric|min:0',
        ]);

        $payrollSetting->update($request->only(['name', 'value']));

        return redirect()->route('payroll_settings.index')->with('success', 'Payroll setting updated successfully.');
    }

    public function destroy(PayrollSetting $payrollSetting)
    {
        $payrollSetting->delete();
        return redirect()->route('payroll_settings.index')->with('success', 'Payroll setting deleted successfully.');
    }
}
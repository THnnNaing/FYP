@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary mb-4">Payroll Settings</h1>
    <a href="{{ route('payroll_settings.create') }}" class="btn btn-primary mb-3">Add Setting</a>
    <div class="card bg-white">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Value</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($settings as $setting)
                        <tr>
                            <td>{{ $setting->name }}</td>
                            <td>{{ number_format($setting->value, 2) }}</td>
                            <td>
                                <a href="{{ route('payroll_settings.edit', $setting) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('payroll_settings.destroy', $setting) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
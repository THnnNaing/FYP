@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary mb-4">Create Payroll</h1>
    <div class="card bg-white p-3">
        <div class="card-body">
            <form action="{{ route('hr.payrolls.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="employee_id" class="form-label">Employee</label>
                    <select name="employee_id" class="form-control" required>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                        @endforeach
                    </select>
                    @error('employee_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="month" class="form-label">Month</label>
                    <input type="month" name="month" class="form-control" value="{{ old('month') }}" required>
                    @error('month') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="worked_days" class="form-label">Worked Days (Non-Permanent Only)</label>
                    <input type="number" name="worked_days" class="form-control" value="{{ old('worked_days') }}" min="0" max="30">
                    @error('worked_days') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Bonuses (Optional)</label>
                    <div id="bonuses">
                        <div class="bonus-entry mb-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <select name="bonuses[0][bonus_type_id]" class="form-control">
                                        <option value="">Select Bonus Type</option>
                                        @foreach($bonusTypes as $bonusType)
                                            <option value="{{ $bonusType->id }}">{{ $bonusType->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('bonuses.*.bonus_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-4">
                                    <input type="number" name="bonuses[0][amount]" class="form-control" placeholder="Amount" step="0.01" min="0">
                                    @error('bonuses.*.amount') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger remove-bonus">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary mt-2" id="add-bonus">Add Bonus</button>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deductions (Optional)</label>
                    <div id="deductions">
                        <div class="deduction-entry mb-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <select name="deductions[0][deduction_type_id]" class="form-control">
                                        <option value="">Select Deduction Type</option>
                                        @foreach($deductionTypes as $deductionType)
                                            <option value="{{ $deductionType->id }}">{{ $deductionType->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('deductions.*.deduction_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-4">
                                    <input type="number" name="deductions[0][amount]" class="form-control" placeholder="Amount" step="0.01" min="0">
                                    @error('deductions.*.amount') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger remove-deduction">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary mt-2" id="add-deduction">Add Deduction</button>
                </div>
                <button type="submit" class="btn btn-primary">Create Payroll</button>
            </form>
        </div>
    </div>
</div>

<script>
    let bonusIndex = 1;
    document.getElementById('add-bonus').addEventListener('click', function() {
        const container = document.getElementById('bonuses');
        const entry = document.createElement('div');
        entry.className = 'bonus-entry mb-2';
        entry.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <select name="bonuses[${bonusIndex}][bonus_type_id]" class="form-control">
                        <option value="">Select Bonus Type</option>
                        @foreach($bonusTypes as $bonusType)
                            <option value="{{ $bonusType->id }}">{{ $bonusType->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="number" name="bonuses[${bonusIndex}][amount]" class="form-control" placeholder="Amount" step="0.01" min="0">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-bonus">Remove</button>
                </div>
            </div>
        `;
        container.appendChild(entry);
        bonusIndex++;
    });

    let deductionIndex = 1;
    document.getElementById('add-deduction').addEventListener('click', function() {
        const container = document.getElementById('deductions');
        const entry = document.createElement('div');
        entry.className = 'deduction-entry mb-2';
        entry.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <select name="deductions[${deductionIndex}][deduction_type_id]" class="form-control">
                        <option value="">Select Deduction Type</option>
                        @foreach($deductionTypes as $deductionType)
                            <option value="{{ $deductionType->id }}">{{ $deductionType->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="number" name="deductions[${deductionIndex}][amount]" class="form-control" placeholder="Amount" step="0.01" min="0">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-deduction">Remove</button>
                </div>
            </div>
        `;
        container.appendChild(entry);
        deductionIndex++;
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-bonus')) {
            e.target.closest('.bonus-entry').remove();
        }
        if (e.target.classList.contains('remove-deduction')) {
            e.target.closest('.deduction-entry').remove();
        }
    });
</script>
@endsection
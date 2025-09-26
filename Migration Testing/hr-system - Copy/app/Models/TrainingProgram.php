<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'details',
        'instructor_employee_id',
        'available_days',
        'available_total_employees',
        'available_time',
        'status',
    ];

    protected $casts = [
        'available_days' => 'array',
        'status' => 'string',
    ];

    public function instructor()
    {
        return $this->belongsTo(Employee::class, 'instructor_employee_id');
    }

    public function assignments()
    {
        return $this->hasMany(TrainingAssignment::class);
    }
}
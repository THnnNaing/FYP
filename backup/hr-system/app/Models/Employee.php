<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Department;
use App\Models\Designation;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'department_id',
        'designation_id',
        'first_name',
        'last_name',
        'dob',
        'address',
        'nrc',
        'phonenumber',
        'email',
        'status',
        'basic_salary',
    ];

    protected $casts = [
        'status' => 'string',
        'dob' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
}
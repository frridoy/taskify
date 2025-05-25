<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeSalary extends Model
{
    protected $fillable = [
    'user_id',
    'month',
    'year',
    'basic_salary',
    'bonus',
    'total_salary',
    'distribute_by',
];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function distributeBy()
    {
        return $this->belongsTo(User::class, 'distribute_by', 'id');
    }

}

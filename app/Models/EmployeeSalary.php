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
];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}

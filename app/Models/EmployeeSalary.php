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

}

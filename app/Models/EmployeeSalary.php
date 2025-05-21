<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeSalary extends Model
{
    protected $fillable = [
    'user_id',
    'salary_month',
    'salary_year',
    'basic_salary',
    'bonus',
    'deductions',
    'net_salary',
    'paid_on',
    'payment_status',
    'payment_method',
    'created_by',
    'notes',
];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    protected $fillable = [
        'title',
        'description',
        'location',
        'employment_type',
        'vacancies',
        'age_limit',
        'sex',
        'salary_min',
        'salary_max',
        'currency',
        'deadline',
        'is_active'
    ];

    protected $casts = [
        'deadline' => 'date',
        'is_active' => 'boolean',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2'
    ];

    /**
     * Get the education requirements for the job post.
     */
    public function educationRequirements()
    {
        return $this->hasMany(JobPostEducation::class);
    }
}

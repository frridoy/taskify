<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Degree extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'is_active'];

    /**
     * Get the job post educations for the degree.
     */
    public function jobPostEducations()
    {
        return $this->hasMany(JobPostEducation::class);
    }

    /**
     * Get the job posts that require this degree.
     */
    public function jobPosts()
    {
        return $this->belongsToMany(JobPost::class, 'job_post_educations')
            ->withPivot('institute_name', 'start_year', 'end_year', 'result')
            ->withTimestamps();
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPostEducation extends Model
{
    protected $fillable = [
        'job_post_id',
        'degree_id',
        'institute_name',
        'start_year',
        'end_year',
        'result'
    ];

    protected $casts = [
        'start_year' => 'integer',
        'end_year' => 'integer'
    ];

    /**
     * Get the job post that owns the education requirement.
     */
    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }

    /**
     * Get the degree that owns the education requirement.
     */
    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }
}

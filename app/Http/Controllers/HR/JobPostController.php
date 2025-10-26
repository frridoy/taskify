<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\Degree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobPostController extends Controller
{

    public function index() {}


    public function create()
    {
        $degrees = Degree::where('is_active', 1)
            ->orderBy('name')
            ->get();
        return view('hr.job_posts.create', compact('degrees'));
    }

    public function store(Request $request)
    {
    }


    public function show(JobPost $jobPost)
    {

    }

    public function edit(JobPost $jobPost)
    {

    }

    public function update(Request $request, JobPost $jobPost) {

    }
}

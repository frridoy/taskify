<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Degree;
use Illuminate\Http\Request;

class DegreeController extends Controller
{
    /**
     * Display a listing of all degrees.
     */
    public function index()
    {
        $degrees = Degree::orderBy('name')->paginate(10);
        return view('hr.degrees.index', compact('degrees'));
    }

    /**
     * Show the form for creating a new degree.
     */
    public function create()
    {
        return view('hr.degrees.create');
    }

    /**
     * Store a newly created degree in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:degrees,name'
        ]);

        Degree::create([
            'name' => $validated['name'],
            'is_active' => true
        ]);

        return redirect()->route('hr.degrees.index')
            ->with('success', 'Degree created successfully.');
    }

    /**
     * Show the form for editing the specified degree.
     */
    public function edit(Degree $degree)
    {
        return view('hr.degrees.edit', compact('degree'));
    }

    /**
     * Update the specified degree in storage.
     */
    public function update(Request $request, Degree $degree)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:degrees,name,' . $degree->id,
            'is_active' => 'boolean'
        ]);

        $degree->update([
            'name' => $validated['name'],
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('hr.degrees.index')
            ->with('success', 'Degree updated successfully.');
    }

    /**
     * Remove the specified degree from storage.
     */
    public function destroy(Degree $degree)
    {
        if ($degree->jobPostEducations()->exists()) {
            return back()->with('error', 'Cannot delete degree as it is being used in job posts.');
        }

        $degree->delete();
        return redirect()->route('hr.degrees.index')
            ->with('success', 'Degree deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    // Display a listing of the schools
    public function index()
    {
        $schools = School::all();
        return view('schools.index', compact('schools'));
    }

    // Show the form for creating a new school
    public function create()
    {
        return view('schools.create');
    }

    // Store a newly created school in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);

        School::create($request->all());

        return redirect()->route('schools.index')->with('success', 'School created successfully.');
    }

    // Display the specified school
    public function show(School $school)
    {
        return view('schools.show', compact('school'));
    }

    // Show the form for editing the specified school
    public function edit(School $school)
    {
        return view('schools.edit', compact('school'));
    }

    // Update the specified school in the database
    public function update(Request $request, School $school)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);

        $school->update($request->all());

        return redirect()->route('schools.index')->with('success', 'School updated successfully.');
    }

    // Remove the specified school from the database
    public function destroy(School $school)
    {
        $school->delete();

        return redirect()->route('schools.index')->with('success', 'School deleted successfully.');
    }
}
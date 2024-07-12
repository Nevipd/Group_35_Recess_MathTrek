<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    // Display a listing of the challenges
    public function index()
    {
        $challenges = Challenge::all();
        return view('challenges.index', compact('challenges'));
    }

    // Show the form for creating a new challenge
    public function create()
    {
        return view('challenges.create');
    }

    // Store a newly created challenge in the database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Challenge::create($request->all());

        return redirect()->route('challenges.index')->with('success', 'Challenge created successfully.');
    }

    // Display the specified challenge
    public function show(Challenge $challenge)
    {
        return view('challenges.show', compact('challenge'));
    }

    // Show the form for editing the specified challenge
    public function edit(Challenge $challenge)
    {
        return view('challenges.edit', compact('challenge'));
    }

    // Update the specified challenge in the database
    public function update(Request $request, Challenge $challenge)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $challenge->update($request->all());

        return redirect()->route('challenges.index')->with('success', 'Challenge updated successfully.');
    }

    // Remove the specified challenge from the database
    public function destroy(Challenge $challenge)
    {
        $challenge->delete();

        return redirect()->route('challenges.index')->with('success', 'Challenge deleted successfully.');
    }
}

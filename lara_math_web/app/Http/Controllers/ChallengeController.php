<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Question;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    // to display a listing of the challenges
    public function index()
    {
        $challenges = Challenge::all();
        return view('challenges.index', compact('challenges'));
    }

    // to show the form for creating a new challenge
    public function create()
    {
        return view('challenges.create');
    }

    // to store a newly created challenge in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'num_questions' => 'required|integer|min:1',
            'duration' => 'required|integer|min:1',
            'time_per_question' => 'required|integer|min:1',
        ]);

        // Extract only the necessary fields to prevent mass assignment vulnerabilities
        $data = $request->only(['name', 'description', 'start_date', 'end_date', 'num_questions', 'duration', 'time_per_question']);
        $challenge = Challenge::create($data);

        $questions = Question::inRandomOrder()->take($data['num_questions'])->get();
        foreach ($questions as $question) {
            $challenge->questions()->attach($question->id);
        }

        return redirect()->route('challenges.index')->with('success', 'Challenge created successfully.');
    }

    // to display the specified challenge
    public function show(Challenge $challenge)
    {
        return view('challenges.show', compact('challenge'));
    }

    // to show the form for editing the specified challenge
    public function edit(Challenge $challenge)
    {
        return view('challenges.edit', compact('challenge'));
    }

    // to update the specified challenge in the database
    public function update(Request $request, Challenge $challenge)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'num_questions' => 'required|integer|min:1',
            'duration' => 'required|integer|min:1',
            'time_per_question' => 'required|integer|min:1',
        ]);

        // to etract only the necessary fields to prevent mass assignment vulnerabilities
        $data = $request->only(['name', 'description', 'start_date', 'end_date', 'num_questions', 'duration', 'time_per_question']);
        $challenge->update($data);

        $challenge->questions()->detach();
        $questions = Question::inRandomOrder()->take($data['num_questions'])->get();
        foreach ($questions as $question) {
            $challenge->questions()->attach($question->id);
        }

        return redirect()->route('challenges.index')->with('success', 'Challenge updated successfully.');
    }

    // Remove the specified challenge from the database
    public function destroy(Challenge $challenge)
    {
        $challenge->delete();

        return redirect()->route('challenges.index')->with('success', 'Challenge deleted successfully.');
    }

    //function to handle more logic
    // public function createChallenges()
    // {
    //     $numChallenges = 10; // Number of challenges to create
    //     $questionsPerChallenge = 10; // Number of questions per challenge

    //     for ($i = 0; $i < $numChallenges; $i++) {
    //         $challenge = Challenge::create([
    //             'name' => 'Challenge ' . ($i + 1),
    //             'description' => 'Description for challenge ' . ($i + 1),
    //             'start_date' => now(),
    //             'end_date' => now()->addDays(7),
    //         ]);

    //         $questions = Question::inRandomOrder()->take($questionsPerChallenge)->get();

    //         foreach ($questions as $question) {
    //             $challenge->questions()->attach($question->id);
    //         }
    //     }

    //     return redirect()->route('challenges.index')->with('success', 'Challenges created successfully.');
    // }
}

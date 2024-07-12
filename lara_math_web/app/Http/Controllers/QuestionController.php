<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    // Display a listing of the questions
    public function index()
    {
        $questions = Question::all();
        return view('questions.index', compact('questions'));
    }

    // Show the form for creating a new question
    public function create()
    {
        return view('questions.create');
    }

    // Store a newly created question in the database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Question::create($request->all());

        return redirect()->route('questions.index')->with('success', 'Question created successfully.');
    }

    // Display the specified question
    public function show(Question $question)
    {
        return view('questions.show', compact('question'));
    }

    // Show the form for editing the specified question
    public function edit(Question $question)
    {
        return view('questions.edit', compact('question'));
    }

    // Update the specified question in the database
    public function update(Request $request, Question $question)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $question->update($request->all());

        return redirect()->route('questions.index')->with('success', 'Question updated successfully.');
    }

    // Remove the specified question from the database
    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('questions.index')->with('success', 'Question deleted successfully.');
    }
}

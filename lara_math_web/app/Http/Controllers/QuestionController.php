<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Services\QuestionImportService;
use Illuminate\Http\Request;


class QuestionController extends Controller
{

     // to show the import form 
     public function importForm()
     {
         return view('questions.import');
     }
 
     // import  questions
     public function import(Request $request, QuestionImportService $questionImportService)
    {
        // validate request
        $request->validate([
            'questions_file' => 'required|file|mimes:xlsx,csv',
            'answers_file' => 'required|file|mimes:xlsx,csv',
        ]);

        try {
            // store the uploaded files
            $questionsFilePath = $request->file('questions_file')->store('imports');
            $answersFilePath = $request->file('answers_file')->store('imports');

            // import the questions
            $questionImportService->importQuestions(storage_path('app/' . $questionsFilePath), storage_path('app/' . $answersFilePath));
            return redirect()->route('questions.index')->with('success', 'Questions imported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to import questions: ' . $e->getMessage()]);
        }
    }

    //to use the service through a constructor
    protected $questionImportService;
    public function __construct(QuestionImportService $questionImportService)
    {
        $this->questionImportService = $questionImportService;
    }


    // to display a listing of the questions
    public function index()
    {
        $questions = Question::all();
        return view('questions.index', compact('questions'));
    }

    // to show the form for creating a new question
    public function create()
    {
        return view('questions.create');
    }

    // to store a newly created question in the database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Question::create($request->all());

        return redirect()->route('questions.index')->with('success', 'Question created successfully.');
    }

    // to display the specified question
    public function show(Question $question)
    {
        return view('questions.show', compact('question'));
    }

    // to show the form for editing the specified question
    public function edit(Question $question)
    {
        return view('questions.edit', compact('question'));
    }

    // to update the specified question in the database
    public function update(Request $request, Question $question)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $question->update($request->all());

        return redirect()->route('questions.index')->with('success', 'Question updated successfully.');
    }

    // to remove the specified question from the database
    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('questions.index')->with('success', 'Question deleted successfully.');
    }

    
}

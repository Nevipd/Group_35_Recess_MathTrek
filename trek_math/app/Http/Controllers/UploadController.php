<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ExcelImportService;

class UploadController extends Controller
{
    protected $excelImportService;

    public function __construct(ExcelImportService $excelImportService)
    {
        $this->excelImportService = $excelImportService;
    }

    public function showUploadForm()
    {
        return view('upload');
    }

    public function uploadQuestions(Request $request)
    {
        $request->validate([
            'questions_file' => 'required|file|mimes:xlsx',
            'answers_file' => 'required|file|mimes:xlsx',
        ]);

        $questionsFilePath = $request->file('questions_file')->store('temporary');
        $answersFilePath = $request->file('answers_file')->store('temporary');

        $this->excelImportService->importQuestions(storage_path('app/' . $questionsFilePath));
        $this->excelImportService->importAnswers(storage_path('app/' . $answersFilePath));

        return redirect()->back()->with('success', 'Questions and answers uploaded successfully!');
    }
}

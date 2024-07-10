<?php

namespace App\Services;

use App\Models\Question;
use App\Models\Answer;
use App\Imports\QuestionsImport;
use App\Imports\AnswersImport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelImportService
{
    public function importQuestions($filePath)
    {
        Excel::import(new QuestionsImport, $filePath);
    }

    public function importAnswers($filePath)
    {
        Excel::import(new AnswersImport, $filePath);
    }
}

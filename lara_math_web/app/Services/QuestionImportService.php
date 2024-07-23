<?php
//additional adjustment
namespace App\Services;

use App\Models\Question;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Support\Facades\Log;

class QuestionImportService
{
    public function importQuestions(string $questionsFilePath, string $answersFilePath)
    {
        $questions = SimpleExcelReader::create($questionsFilePath)->getRows()->toArray();
        $answers = SimpleExcelReader::create($answersFilePath)->getRows()->keyBy('question_text')->toArray();

        foreach ($questions as $questionRow) {
            if (!isset($questionRow['question_text'], $questionRow['choice1'], $questionRow['choice2'], $questionRow['choice3'], $questionRow['choice4'])) {
                Log::warning('Missing question fields: ' . json_encode($questionRow));
                continue;
            }

            $questionText = $questionRow['question_text'];

            if (!isset($answers[$questionText])) {
                Log::warning("No matching answer found for question: $questionText");
                continue;
            }

            $correctChoice = $answers[$questionText]['correct_choice'];

            Question::create([
                'question_text' => $questionText,
                'choice1' => $questionRow['choice1'],
                'choice2' => $questionRow['choice2'],
                'choice3' => $questionRow['choice3'],
                'choice4' => $questionRow['choice4'],
                'correct_choice' => $correctChoice,
            ]);
        }
    }
}

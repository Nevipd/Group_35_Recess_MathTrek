<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuestionsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Question([
            'question_text' => $row['question_text'] ?? null,
            'option_a' => $row['option_a'] ?? null,
            'option_b' => $row['option_b'] ?? null,
            'option_c' => $row['option_c'] ?? null,
            'option_d' => $row['option_d'] ?? null,
            'correct_answer' => $row['correct_answer'] ?? null,
        ]);
    }
}

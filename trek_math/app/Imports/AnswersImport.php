<?php

namespace App\Imports;

use App\Models\Answer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AnswersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Answer([
            /** */
            'question_id' => $row['question_id'] ?? null,
            'answer_text' => $row['answer_text'] ?? null,
        ]);
    }
}

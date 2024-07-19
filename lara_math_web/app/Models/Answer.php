<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
        /** here i specified the fields */
        protected $fillable = ['question_id', 'answer_text', 'marks'];
        /** */
}

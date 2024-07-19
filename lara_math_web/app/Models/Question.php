<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    /** here i specified the fields  */
    protected $fillable = ['question_text', 'choice1', 'choice2', 'choice3', 'choice4', 'correct_choice'];
    /** */
}

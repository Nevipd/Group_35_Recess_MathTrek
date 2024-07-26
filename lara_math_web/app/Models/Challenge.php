<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;
    /**here i specified the fields  */
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'num_questions',
        'duration',
        'time_per_question',
    ];
    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }

    // function for averages
    public function getAverageMarksAttribute()
    {
        return $this->participants->avg('pivot.marks');
    }
        
    // many to many relationship
    public function participants()
    {
        return $this->belongsToMany(Participant::class)->withPivot('marks')->withTimestamps();
    }

    
    public function getBestMarksAttribute()
    {
        return $this->participants()->max('pivot.marks');
    }
    
    public function getWorstMarksAttribute()
    {
        return $this->participants()->min('pivot.marks');
    }
    
}

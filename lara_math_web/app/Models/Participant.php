<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;
    /** here i specified the fields  */
    protected $fillable = ['username', 'first_name', 'last_name', 'email', 'date_of_birth', 'school_registration_number', 'image_file',];
    /** */
    // relationship with the school model
    public function school()
    {
        return $this->belongsTo(School::class, 'school_registration_number', 'school_registration_number');
    }
    // defining the many-to-many relationship with Challenge
    public function challenges()
    {
        return $this->belongsToMany(Challenge::class)->withPivot('marks')->withTimestamps();
    }
    // relationship with pivot table
    public function getAverageMarksAttribute()
    {
        return $this->challenges()->avg('pivot.marks');
    }
    
    public function getTotalMarksAttribute()
    {
        return $this->challenges()->sum('pivot.marks');
    }
    

}

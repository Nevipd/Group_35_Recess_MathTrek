<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    /** here i specified the fields */
    protected $fillable = [
        'name',
        'address',
        'school_registration_number',
        'representative_email',
        'representative_name',
    ];
    
    // the relationship with the Participant model defined
    public function participants()
    {
        return $this->hasMany(Participant::class, 'school_registration_number', 'school_registration_number');
    }

    // specify relationship with representative
    public function representative()
    {
        return $this->hasOne(Representative::class);
    }

}

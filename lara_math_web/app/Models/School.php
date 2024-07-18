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
    /** */
}

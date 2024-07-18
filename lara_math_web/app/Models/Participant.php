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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    /** here i specified the fields */
    protected $fillable = [
        'title',
        'content',
    ];
    /** */
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $fillable = [
        'student_id',
        'name',
        'description',
        'start_date',
        'end_date',
    ];

    protected $table = 'educations';
    use HasFactory;
}

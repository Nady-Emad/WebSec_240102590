<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranscriptCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_name',
        'student_number',
        'major',
        'course_code',
        'title',
        'credit_hours',
        'grade',
    ];

    protected function casts(): array
    {
        return [
            'credit_hours' => 'float',
        ];
    }
}

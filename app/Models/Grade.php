<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'term',
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

    public static function gradePointsMap(): array
    {
        return [
            'A+' => 4.0,
            'A' => 4.0,
            'A-' => 3.7,
            'B+' => 3.3,
            'B' => 3.0,
            'B-' => 2.7,
            'C+' => 2.3,
            'C' => 2.0,
            'C-' => 1.7,
            'D+' => 1.3,
            'D' => 1.0,
            'F' => 0.0,
        ];
    }
}

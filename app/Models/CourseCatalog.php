<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCatalog extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_code',
        'title',
        'credit_hours',
    ];

    protected function casts(): array
    {
        return [
            'credit_hours' => 'float',
        ];
    }
}

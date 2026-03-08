<?php

namespace Database\Seeders;

use App\Models\BillItem;
use App\Models\CourseCatalog;
use App\Models\Product;
use App\Models\Question;
use App\Models\TranscriptCourse;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::query()->firstOrCreate(
            ['email' => 'admin@websec.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::query()->firstOrCreate(
            ['email' => 'instructor@websec.com'],
            [
                'name' => 'Lab Instructor',
                'password' => Hash::make('password'),
                'role' => 'instructor',
            ]
        );

        User::query()->firstOrCreate(
            ['email' => 'student@websec.com'],
            [
                'name' => 'Exam Student',
                'password' => Hash::make('password'),
                'role' => 'student',
            ]
        );

        Product::query()->updateOrCreate(
            ['code' => 'PRD-1001'],
            [
                'name' => 'Smart Phone X',
                'price' => 799.99,
                'model' => 'SPX-2026',
                'description' => '6.5-inch display, 128GB storage, dual camera.',
                'photo' => 'https://sm.pcmag.com/pcmag_uk/photo/a/apple-ipho/apple-iphone-17-in-hand_f7d1.jpg',
            ]
        );

        Product::query()->updateOrCreate(
            ['code' => 'PRD-1002'],
            [
                'name' => 'Laptop Pro 14',
                'price' => 1299.00,
                'model' => 'LTP-14',
                'description' => '14-inch business laptop with 16GB RAM and SSD.',
                'photo' => 'https://sm.pcmag.com/pcmag_uk/photo/a/apple-ipho/apple-iphone-17-in-hand_f7d1.jpg',
            ]
        );

        $billItems = [
            ['name' => 'Apples', 'quantity' => 2, 'price' => 1.50],
            ['name' => 'Milk', 'quantity' => 1, 'price' => 2.25],
            ['name' => 'Bread', 'quantity' => 3, 'price' => 1.10],
            ['name' => 'Eggs', 'quantity' => 1, 'price' => 3.00],
        ];

        foreach ($billItems as $item) {
            BillItem::query()->updateOrCreate(['name' => $item['name']], $item);
        }

        $transcriptRows = [
            ['course_code' => 'CS101', 'title' => 'Intro to Programming', 'credit_hours' => 3.0, 'grade' => 'A'],
            ['course_code' => 'CS205', 'title' => 'Data Structures', 'credit_hours' => 3.0, 'grade' => 'B+'],
            ['course_code' => 'MATH201', 'title' => 'Discrete Mathematics', 'credit_hours' => 3.0, 'grade' => 'A-'],
            ['course_code' => 'STAT210', 'title' => 'Probability', 'credit_hours' => 2.0, 'grade' => 'B'],
        ];

        foreach ($transcriptRows as $row) {
            TranscriptCourse::query()->updateOrCreate(
                ['course_code' => $row['course_code']],
                array_merge($row, [
                    'student_name' => 'Nady Student',
                    'student_number' => '20260001',
                    'major' => 'Computer Science',
                ])
            );
        }

        $catalogRows = [
            ['course_code' => 'CS301', 'title' => 'Algorithms', 'credit_hours' => 3.0],
            ['course_code' => 'CS315', 'title' => 'Database Systems', 'credit_hours' => 3.0],
            ['course_code' => 'CS320', 'title' => 'Operating Systems', 'credit_hours' => 3.0],
            ['course_code' => 'MATH310', 'title' => 'Linear Algebra', 'credit_hours' => 2.0],
            ['course_code' => 'ENG201', 'title' => 'Technical Writing', 'credit_hours' => 2.0],
        ];

        foreach ($catalogRows as $row) {
            CourseCatalog::query()->updateOrCreate(['course_code' => $row['course_code']], $row);
        }

        $questions = [
            [
                'question_text' => 'What does SQL stand for?',
                'option_a' => 'Structured Query Language',
                'option_b' => 'Simple Query List',
                'option_c' => 'System Query Language',
                'option_d' => 'Sequential Query Logic',
                'correct_option' => 'A',
            ],
            [
                'question_text' => 'Which HTTP method is usually used to create a new record?',
                'option_a' => 'GET',
                'option_b' => 'POST',
                'option_c' => 'PUT',
                'option_d' => 'DELETE',
                'correct_option' => 'B',
            ],
        ];

        foreach ($questions as $question) {
            Question::query()->updateOrCreate(
                ['question_text' => $question['question_text']],
                $question
            );
        }
    }
}

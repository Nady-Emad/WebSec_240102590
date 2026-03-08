<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transcript_courses', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            $table->string('student_number');
            $table->string('major');
            $table->string('course_code');
            $table->string('title');
            $table->decimal('credit_hours', 4, 1);
            $table->string('grade', 3);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transcript_courses');
    }
};

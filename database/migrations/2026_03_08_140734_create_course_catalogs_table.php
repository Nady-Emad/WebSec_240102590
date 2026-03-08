<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_catalogs', function (Blueprint $table) {
            $table->id();
            $table->string('course_code')->unique();
            $table->string('title');
            $table->decimal('credit_hours', 4, 1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_catalogs');
    }
};

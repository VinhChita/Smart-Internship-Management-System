<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $t) {
            $t->id();
            $t->foreignId('intern_id')->constrained('users')->cascadeOnDelete();
            $t->foreignId('supervisor_id')->constrained('users')->cascadeOnDelete();
            $t->foreignId('program_id')->nullable()->constrained('internship_programs')->nullOnDelete();
            $t->unsignedTinyInteger('score'); // 0-100
            $t->text('feedback')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};

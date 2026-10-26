<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $t) {
            $t->id();
            $t->foreignId('intern_id')->constrained('users')->cascadeOnDelete();
            $t->enum('type', ['weekly', 'final'])->default('weekly');
            $t->unsignedTinyInteger('week_number')->nullable();
            $t->string('title');
            $t->text('content');
            $t->string('file_path')->nullable();
            $t->text('supervisor_feedback')->nullable();
            $t->enum('status', ['submitted', 'reviewed'])->default('submitted');
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};

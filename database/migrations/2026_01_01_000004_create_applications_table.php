<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $t) {
            $t->id();
            $t->foreignId('program_id')->constrained('internship_programs')->cascadeOnDelete();
            $t->foreignId('intern_id')->constrained('users')->cascadeOnDelete();
            $t->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $t->text('cover_letter')->nullable();
            $t->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $t->timestamps();
            $t->unique(['program_id', 'intern_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};

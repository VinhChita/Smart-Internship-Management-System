<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $t) {
            $t->id();
            $t->foreignId('intern_id')->constrained('users')->cascadeOnDelete();
            $t->foreignId('supervisor_id')->constrained('users')->cascadeOnDelete();
            $t->date('date');
            $t->enum('status', ['present', 'absent', 'late', 'excused'])->default('present');
            $t->string('note')->nullable();
            $t->timestamps();
            $t->unique(['intern_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};

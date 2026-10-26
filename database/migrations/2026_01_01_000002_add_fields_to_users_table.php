<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->enum('role', ['admin', 'supervisor', 'intern'])->default('intern')->after('email');
            $t->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('role');
            $t->string('phone')->nullable();
            $t->string('telegram')->nullable();
            $t->string('university')->nullable();
            $t->string('major')->nullable();
            $t->string('cv_path')->nullable();
            $t->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->dropConstrainedForeignId('company_id');
            $t->dropColumn(['role', 'status', 'phone', 'telegram', 'university', 'major', 'cv_path']);
        });
    }
};

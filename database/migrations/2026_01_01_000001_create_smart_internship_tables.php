<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void {
 Schema::create('companies',function(Blueprint $t){$t->id();$t->string('name',180);$t->string('industry',120)->nullable();$t->string('contact_name',150)->nullable();$t->string('email',180)->nullable();$t->string('phone',40)->nullable();$t->string('address')->nullable();$t->enum('status',['active','inactive'])->default('active');$t->text('description')->nullable();$t->timestamps();});
 Schema::create('programs',function(Blueprint $t){$t->id();$t->foreignId('company_id')->constrained()->cascadeOnDelete();$t->string('title',180);$t->string('department',120)->nullable();$t->text('description')->nullable();$t->unsignedInteger('slots')->default(1);$t->date('start_date');$t->date('end_date');$t->enum('status',['draft','open','closed'])->default('draft');$t->timestamps();});
 Schema::table('users',function(Blueprint $t){$t->string('phone',40)->nullable();$t->enum('role',['admin','intern','supervisor'])->default('intern');$t->enum('status',['active','inactive'])->default('active');});
 Schema::create('registrations',function(Blueprint $t){$t->id();$t->foreignId('program_id')->constrained()->cascadeOnDelete();$t->foreignId('intern_id')->constrained('users')->cascadeOnDelete();$t->foreignId('supervisor_id')->nullable()->constrained('users')->nullOnDelete();$t->enum('status',['pending','approved','rejected','completed'])->default('pending');$t->date('applied_at')->nullable();$t->text('notes')->nullable();$t->timestamps();$t->unique(['program_id','intern_id']);});
 } public function down(): void { Schema::dropIfExists('registrations'); Schema::table('users',fn(Blueprint $t)=>$t->dropColumn(['phone','role','status'])); Schema::dropIfExists('programs'); Schema::dropIfExists('companies'); } };

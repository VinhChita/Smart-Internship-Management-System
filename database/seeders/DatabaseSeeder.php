<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::create([
            'name' => 'Tech Solution Co.',
            'address' => 'Phnom Penh',
            'contact_email' => 'hr@techsolution.example',
            'contact_phone' => '012 000 000',
        ]);

        $admin = User::create([
            'name' => 'Admin', 'email' => 'admin@example.com', 'password' => 'password',
            'role' => 'admin', 'status' => 'approved',
        ]);

        $supervisor = User::create([
            'name' => 'Vichet Sovanna', 'email' => 'supervisor@example.com', 'password' => 'password',
            'role' => 'supervisor', 'status' => 'approved', 'company_id' => $company->id,
        ]);

        User::create([
            'name' => 'Sokha Routana', 'email' => 'intern@example.com', 'password' => 'password',
            'role' => 'intern', 'status' => 'approved',
            'university' => 'Royal University of Phnom Penh', 'major' => 'Information Technology',
        ]);

        User::create([
            'name' => 'Pending Intern', 'email' => 'pending@example.com', 'password' => 'password',
            'role' => 'intern', 'status' => 'pending',
        ]);

        Program::create([
            'company_id' => $company->id,
            'created_by' => $supervisor->id,
            'title' => 'Frontend Developer',
            'description' => 'Build web UI with Laravel Blade and JavaScript.',
            'field' => 'IT',
            'slots' => 3,
            'deadline' => now()->addMonth()->toDateString(),
            'status' => 'open',
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'internship_programs';
    protected $guarded = [];
    protected $casts = ['deadline' => 'date'];

    public function company() { return $this->belongsTo(Company::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function applications() { return $this->hasMany(Application::class, 'program_id'); }
}

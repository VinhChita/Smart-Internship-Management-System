<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $guarded = [];

    public function intern() { return $this->belongsTo(User::class, 'intern_id'); }
    public function supervisor() { return $this->belongsTo(User::class, 'supervisor_id'); }
    public function program() { return $this->belongsTo(Program::class, 'program_id'); }
}

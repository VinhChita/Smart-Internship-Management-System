<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $guarded = [];

    public function program() { return $this->belongsTo(Program::class, 'program_id'); }
    public function intern() { return $this->belongsTo(User::class, 'intern_id'); }
    public function reviewer() { return $this->belongsTo(User::class, 'reviewed_by'); }
}

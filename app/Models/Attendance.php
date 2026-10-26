<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded = [];
    protected $casts = ['date' => 'date'];

    public function intern() { return $this->belongsTo(User::class, 'intern_id'); }
    public function supervisor() { return $this->belongsTo(User::class, 'supervisor_id'); }
}

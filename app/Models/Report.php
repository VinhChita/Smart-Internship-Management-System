<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $guarded = [];

    public function intern() { return $this->belongsTo(User::class, 'intern_id'); }
}

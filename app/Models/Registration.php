<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Registration extends Model { protected $fillable=['program_id','intern_id','supervisor_id','status','applied_at','notes']; public function program(){return $this->belongsTo(Program::class);} public function intern(){return $this->belongsTo(User::class,'intern_id');} public function supervisor(){return $this->belongsTo(User::class,'supervisor_id');} }

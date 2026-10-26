<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'status',
        'phone', 'telegram', 'university', 'major', 'cv_path', 'company_id',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isSupervisor(): bool { return $this->role === 'supervisor'; }
    public function isIntern(): bool { return $this->role === 'intern'; }

    public function company() { return $this->belongsTo(Company::class); }
    public function applications() { return $this->hasMany(Application::class, 'intern_id'); }
    public function reports() { return $this->hasMany(Report::class, 'intern_id'); }
    public function attendances() { return $this->hasMany(Attendance::class, 'intern_id'); }
    public function evaluations() { return $this->hasMany(Evaluation::class, 'intern_id'); }
    public function appNotifications() { return $this->hasMany(AppNotification::class); }
}

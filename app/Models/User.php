<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'siswa', 'osis', 'guru'
        'nisn_nip',
        'kelas',
        'jurusan_id',
        'jabatan',
        'bio',
        'avatar',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa' || $this->role === 'admin';
    }

    public function isOsis(): bool
    {
        return $this->role === 'osis' || $this->role === 'admin';
    }

    public function isGuru(): bool
    {
        return $this->role === 'guru' || $this->role === 'admin';
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skills')->withPivot(['is_verified', 'level'])->withTimestamps();
    }

    public function projectsLed()
    {
        return $this->hasMany(Project::class, 'lead_id');
    }

    public function projectsMentored()
    {
        return $this->hasMany(Project::class, 'guru_id');
    }

    public function projectsJoined()
    {
        return $this->belongsToMany(Project::class, 'project_members')
            ->withPivot('role_in_project', 'status')
            ->withTimestamps();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'assignee_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function achievements()
    {
        return $this->hasMany(StudentAchievement::class);
    }

    public function portfolios()
    {
        return $this->hasMany(StudentPortfolio::class);
    }
}

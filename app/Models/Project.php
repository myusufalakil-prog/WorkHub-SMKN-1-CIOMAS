<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'lead_id',
        'guru_id',
        'target_members',
        'deadline',
        'progress',
        'status',
        'category',
        'is_showcase',
        'notes_guru',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'date',
            'is_showcase' => 'boolean',
        ];
    }

    public function lead()
    {
        return $this->belongsTo(User::class, 'lead_id');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function jurusans()
    {
        return $this->belongsToMany(Jurusan::class, 'project_jurusans');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members')
            ->withPivot('role_in_project', 'status')
            ->withTimestamps();
    }

    public function activeMembers()
    {
        return $this->belongsToMany(User::class, 'project_members')
            ->wherePivot('status', 'active')
            ->withPivot('role_in_project', 'status')
            ->withTimestamps();
    }

    public function pendingMembers()
    {
        return $this->belongsToMany(User::class, 'project_members')
            ->wherePivot('status', 'pending')
            ->withPivot('role_in_project', 'status')
            ->withTimestamps();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function files()
    {
        return $this->hasMany(ProjectFile::class);
    }

    public function activities()
    {
        return $this->hasMany(ProjectActivity::class)->latest();
    }

    public function messages()
    {
        return $this->hasMany(ProjectMessage::class)->oldest();
    }

    public function getJurusanLabelAttribute(): string
    {
        $codes = $this->relationLoaded('jurusans') || $this->jurusans ? $this->jurusans->pluck('kode')->filter() : collect();
        return $codes->isNotEmpty() ? $codes->implode(' × ') : 'Kolaborasi Lintas Jurusan';
    }
}

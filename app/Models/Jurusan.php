<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $fillable = [
        'kode',
        'nama_lengkap',
        'deskripsi',
        'color_accent',
    ];

    public function students()
    {
        return $this->hasMany(User::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_jurusans');
    }

    public function getIconAttribute(): string
    {
        return match(strtoupper($this->kode)) {
            'TECH' => 'code',
            'AI-DATA' => 'cpu',
            'CYBER' => 'shield',
            'DESIGN' => 'sparkles',
            '3D-GAME' => 'box',
            'MEDIA' => 'video',
            'ENG' => 'settings',
            'BIZ' => 'layers',
            'FIN' => 'dollar-sign',
            'HEALTH' => 'heart',
            'ENV' => 'globe',
            'COMM' => 'message-square',
            default => 'layers',
        };
    }

    public function getThemeColorAttribute(): string
    {
        return match(strtoupper($this->kode)) {
            'TECH' => 'blue',
            'AI-DATA' => 'indigo',
            'CYBER' => 'slate',
            'DESIGN' => 'amber',
            '3D-GAME' => 'violet',
            'MEDIA' => 'purple',
            'ENG' => 'rose',
            'BIZ' => 'cyan',
            'FIN' => 'emerald',
            'HEALTH' => 'teal',
            'ENV' => 'green',
            'COMM' => 'sky',
            default => 'blue',
        };
    }
}

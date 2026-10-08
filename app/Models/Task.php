<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'title',
        'description',
        'assignee_id',
        'priority',
        'status',
        'due_text',
        'due_date',
        'verified_by_guru',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'verified_by_guru' => 'boolean',
        ];
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }
}

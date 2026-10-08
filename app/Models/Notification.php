<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['user_id', 'type', 'title', 'desc', 'icon', 'status', 'action_text', 'action_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAchievement extends Model
{
    protected $fillable = ['user_id', 'title', 'issuer', 'year', 'verified_by_guru_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifiedByGuru()
    {
        return $this->belongsTo(User::class, 'verified_by_guru_id');
    }
}

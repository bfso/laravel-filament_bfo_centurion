<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quest extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_active',
        'quest',
        'experience',
    ];

    public function players()
    {
        return $this->belongsToMany(Player::class)
            ->using(PlayerQuest::class)
            ->withPivot(['id', 'is_started', 'is_successful', 'is_failed']);
    }
}

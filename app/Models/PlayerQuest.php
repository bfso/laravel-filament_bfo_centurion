<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PlayerQuest extends Pivot
{
    use HasFactory;

    //protected $table = 'player_quest';

    protected $fillable = [
        'is_started',
        'is_successful',
        'is_failed',
        'player_id',
        'quest_id',
    ];

    public function quest()
    {
        return $this->belongsTo(Quest::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}

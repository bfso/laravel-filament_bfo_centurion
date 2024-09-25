<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'level',
        'health',
        'experience',
        'force',
        'intelligence',
        'agility',
        'energy',
        'gold',
        'map_field_id',
        'user_id',
    ];

    protected $hidden = [
        'map_field_id',
        'mapField',
        'created_at',
        'updated_at',
        'user_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }


    public function mapField()
    {
        return $this->belongsTo(MapField::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function quests()
    {
        return $this->belongsToMany(Quest::class)
            ->using(PlayerQuest::class)
            ->withPivot(['id', 'is_started', 'is_successful', 'is_failed']);
    }

    public function guilds()
    {
        return $this->belongsToMany(Guild::class)
            ->withPivot('is_approved');
    }
}

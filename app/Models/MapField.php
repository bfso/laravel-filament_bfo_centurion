<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapField extends Model
{
    use HasFactory;

    protected $fillable = [
        'x',
        'y',
        'z',
    ];

    public function items(){
        return $this->belongsToMany(Item::class,'map_field_items');
    }

    public function players(){
        return $this->hasMany(Player::class);
    }
}

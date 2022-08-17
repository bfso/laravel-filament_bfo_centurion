<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapFieldItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'map_field_id',
        'player_id',
    ];

    public function mapField(){
        return $this->belongsTo(MapField::class);
    }

    public function item(){
        return $this->belongsTo(Item::class);
    }
}

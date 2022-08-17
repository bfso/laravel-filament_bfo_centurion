<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'slots',
        'equippable',
        'player_id',
        'map_field_id',
    ];

    protected $with = ['items'];

    public function mapField(){
        return $this->belongsTo(MapField::class);
    }

    public function items(){
        return $this->belongsToMany(Item::class)
            ->using(InventoryItem::class);
    }
}

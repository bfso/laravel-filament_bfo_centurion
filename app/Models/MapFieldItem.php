<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MapFieldItem extends Pivot
{
    use HasFactory;

    protected $table = 'map_field_items';

    protected $fillable = [
        'item_id',
        'map_field_id',
        'player_id',
    ];

    public function mapField()
    {
        return $this->belongsTo(MapField::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}

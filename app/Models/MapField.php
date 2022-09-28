<?php

namespace App\Models;

use App\Domain\Map\Position;
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

    public function items()
    {
        return $this->belongsToMany(Item::class, 'map_field_items')
            ->using(MapFieldItem::class)
            ->withPivot('id');
    }

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function position()
    {
        return new Position(
            $this->x,
            $this->y,
            $this->z,
        );
    }
}

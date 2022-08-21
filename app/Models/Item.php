<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model {
    use HasFactory;

    protected $fillable = [
        'key',
        'title',
        'description',
        'craftable',
        'moveable',
        'buildable',
        'takeable',
        'eatable',
        'claimable',
        'equippable',
        'image_path',
        'restores_health_by',
    ];

    public function blueprints(){
        return $this->belongsToMany(Item::class,'item_blueprints','item_id','required_item_id')->withPivot('count');
    }
}

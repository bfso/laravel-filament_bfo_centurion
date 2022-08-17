<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class InventoryItem extends Pivot
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'inventory_id',
    ];

    public function item(){
        return $this->belongsTo(Item::class);
    }
}

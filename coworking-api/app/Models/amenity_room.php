<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AmenityRoom extends Pivot
{
    public $timestamps = true;


    protected $fillable = [
        'amenity_id',
        'room_id',
    ];
}

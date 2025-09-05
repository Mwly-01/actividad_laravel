<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'amenity_room');
    }
}

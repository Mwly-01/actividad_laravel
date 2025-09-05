<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function space()
    {
        return $this->belongsTo(Space::class);
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'amenity_room');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Space;
use App\Models\Amenity;
use App\Models\Booking;

class Room extends Model
{
    /** @use HasFactory<\Database\Factories\PlanFactory> */
    use HasFactory, SoftDeletes;
    protected $table = "rooms";

    protected $fillable = [
        'space_id',
        'name',
        'capacity',
        'type',
        'is_active'
    ];
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

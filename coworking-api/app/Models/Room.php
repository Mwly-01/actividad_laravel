<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Space;
use App\Models\AmenityRoom;
use App\Models\Booking;

class Room extends Model
{
    /** @use HasFactory<\Database\Factories\RoomFactory> */
    use HasFactory, SoftDeletes;

    protected $table = "rooms";

    protected $fillable = [
        'space_id',
        'name',
        'capacity',
        'type',
        'is_active'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function spaces()
    {
        return $this->belongsTo(Space::class, 'space_id');
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class)->using(AmenityRoom::class)->withTimestamps();
    }

    public function bookings()
    {
        return $this->belongsTo(Booking::class);
    }
}

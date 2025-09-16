<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\AmenityRoom;

class Amenity extends Model
{
    /** @use HasFactory<\Database\Factories\AmenityFactory> */
    use HasFactory, SoftDeletes;

    protected $table = "amenities";

    protected $fillable = ['name'];

    protected $casts = [
        'published_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function rooms()
    {
        return $this->belongsToMany(Room::class)->using(AmenityRoom::class)->withTimestamps();
    }
}

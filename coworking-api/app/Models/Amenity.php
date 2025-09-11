<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Room;
use App\Models\Amenity_room;

class Amenity extends Model
{
    /** @use HasFactory<\Database\Factories\PlanFactory> */
    use HasFactory, SoftDeletes;

    protected $table = "amenities";

    protected $fillable = [
        'name'
    ];    
    public function rooms()
    {
        return $this->belogsToMany(Room::class)->using(Amenity_room::class)
        ->withTimestamps();
    }
}

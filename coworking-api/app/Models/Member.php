<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Member;
use App\Models\User;
use App\Models\Plan;
use App\Models\Booking;

class Plan extends Model
{
    /** @use HasFactory<\Database\Factories\PlanFactory> */
    use HasFactory, SoftDeletes;

    protected $table = "members";

    protected $fillable = [
        'user_id',
        'plan_id',
        'company',
        'joined_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}



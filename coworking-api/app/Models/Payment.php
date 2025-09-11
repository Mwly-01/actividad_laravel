<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Booking;
use App\Models\Invoice;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "payments";

    protected $fillable = [
        'booking_id',
        'method',
        'amount',
        'status',
    ];
    public function booking()
    {
        return $this->hasMany(Booking::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}


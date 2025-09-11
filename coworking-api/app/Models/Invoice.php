<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Payment;


class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "invoices";

    protected $fillable = [
        'payment_id',
        'number',
        'issued_date',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function payment()
    {
        return $this->hasMany(Payment::class);
    }
}

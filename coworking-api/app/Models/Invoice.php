<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Payment;

class Invoice extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceFactory> */
    use HasFactory, SoftDeletes;

    protected $table = "invoices";

    protected $fillable = [
        'payment_id',
        'number',
        'issued_date',
        'meta'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'deleted_at' => 'datetime',
        'meta' => 'array'
    ];

    public function payments()
    {
        return $this->belongsTo(Payment::class);
    }
}

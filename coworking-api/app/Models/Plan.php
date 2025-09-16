<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Member;

class Plan extends Model
{
    /** @use HasFactory<\Database\Factories\PlanFactory> */
    use HasFactory, SoftDeletes;

    protected $table = "plans";

    protected $fillable = [
        'name',
        'monthly_hours',
        'guest_passes',
        'price'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function members()
    {
        return $this->hasMany(Member::class);
    }
}

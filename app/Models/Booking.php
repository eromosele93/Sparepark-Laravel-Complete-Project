<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['date_time', 'duration', 'amount', 'user_id', 'space_id'];

    public function user(): BelongsTo{
        return $this->belongsTo(\App\Models\User::class);
    }

    public function space(): BelongsTo{

        return $this->belongsTo(\App\Models\Space::class);
    }
    public function review(): HasOne{

        return $this->hasOne(\App\Models\Review::class);
    }
}

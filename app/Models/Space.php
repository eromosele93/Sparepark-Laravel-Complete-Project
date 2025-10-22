<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Space extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['address', 'postcode', 'city', 'rate', 'category', 'ev', 'name', 'longitude', 'latitude'];

    public static array $ev = ['Yes', 'No'];
    public static array $category = ['Garrage', 'Private Drive-Way', 'Street Parking'];

    public function spaceOwner(): BelongsTo{
        return $this->belongsTo(\App\Models\SpaceOwner::class);
    }
    public function bookings(): HasMany{
        return $this->hasMany(\App\Models\Booking::class);
    }
    public function reviews(): HasMany{
        return $this->hasMany(\App\Models\Review::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SpaceOwner extends Model
{
    use HasFactory;
    protected $fillable = ['phone'];

    public function user(): BelongsTo{
        return $this->belongsTo(\App\Models\User::class);

    }
    public function spaces(): HasMany{
        return $this->hasMany(\App\Models\Space::class);
    }
}

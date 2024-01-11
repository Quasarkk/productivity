<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;



class SubPillar extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
    ];

    public function pillar(): BelongsTo
    {
        return $this->belongsTo(Pillar::class, 'foreign_key');
    }

    public function objective(): HasMany
    {
        return $this->hasMany(Objective::class);
    }
}

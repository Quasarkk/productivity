<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Objective extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'deadline',
        'subpillar_id'
    ];

    public function subpillar(): BelongsTo
    {
        return $this->belongsTo(Subpillar::class, 'subpillar_id');
    }

    public function subobjectives(): HasMany
    {
        return $this->hasMany(Subobjective::class);
    }

}

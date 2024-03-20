<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Subobjective extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'deadline',
        'description',
        'objective_id',
    ];

    public function subpillar(): BelongsTo
    {
        return $this->belongsTo(Subpillar::class, 'subpillar_id');
    }

    public function objective(): BelongsTo
    {
        return $this->belongsTo(Objective::class, 'objective_id');
    }

    public function routine(): HasMany
    {
        return $this->hasMany(Routine::class);
    }
}

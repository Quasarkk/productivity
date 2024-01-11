<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Routine extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'dates',
        'when',
    ];
    public function task(): HasMany
    {
        return $this->hasMany(Task::class);
    }


    // If routine needs to be linked to pillar, subpillar, objective OR subjective a polymorphic would be needed. For a MVP this is ok like this
    public function subobjective(): BelongsTo
    {
        return $this->belongsTo(Subobjective::class, 'foreign_key');
    }
}

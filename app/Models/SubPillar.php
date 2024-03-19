<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;



class Subpillar extends Model
{
    use HasFactory;    protected $fillable = [
        'name',
        'description',
        'pillar_id'
    ];

    public function pillar(): BelongsTo
    {
        return $this->belongsTo(Pillar::class, 'pillar_id');
    }

    public function objectives()
    {
        return $this->hasMany(Objective::class, 'subpillar_id');
    }
}

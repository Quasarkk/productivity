<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\hasMany;


class Pillar extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'ideal',
    ];

    public function subpillar(): HasMany
    {
        return $this->hasMany(Subpillar::class);
    }

    
}

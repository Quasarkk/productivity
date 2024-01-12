<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
    'name',
    'dates',
    'status',
    'taskable_id',
    'taskable_type',
    ];

    public function taskable()
    {
        return $this->morphTo();
    }

    public function scopeTasksDone($query)
    {
        return $query->where('status', 'done');
    }

    public function scopeTasksNotDone($query)
    {
        return $query->where('status', 'not done');
    }
}


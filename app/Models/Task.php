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
    'begin_hour',
    'end_hour',
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

    public function user()
    {
        return $this->belongsTo(User::class); // Assurez-vous que le namespace du modèle User est correct
    }
}


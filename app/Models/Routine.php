<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Carbon\Carbon;

class Routine extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'dates',
        'subobjective_id',
        'frequency',
        'begin_hour',
        'end_hour',
    ];
    protected $casts = [
        'frequency' => 'array',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'taskable_id');
    }

    // If routine needs to be linked to pillar, subpillar, objective OR subjective a polymorphic would be needed. For a MVP this is ok like this
    public function subobjective(): BelongsTo
    {
        return $this->belongsTo(Subobjective::class, 'subobjective_id');
    }

    public function createRecurringTasks() {
        $frequency = $this->frequency; // Assurez-vous que c'est un tableau de jours
        $endDate = Carbon::now()->addMonth(); // Limite la création des tâches à un mois

        foreach ($frequency as $day) {
            $date = Carbon::now()->next($day); // Trouve la prochaine occurrence du jour spécifié

            while ($date->lte($endDate)) {
                Task::create([
                    'name' => $this->name,
                    'taskable_type' => Routine::class,
                    'taskable_id' => $this->id,

                    'begin_hour' => $this->begin_hour,
                    'end_hour'=> $this->end_hour,
                    // Assurez-vous de ne pas avoir de 'routine_id' ici
                    'dates' => $date->toDateString(),
                ]);
                $date->addWeek(); // Passe à la semaine suivante
            }
        }
    }

    public function deleteFutureTasksRoutine()
    {
        $this->tasks()
            ->where('dates', '>', now())
            ->delete();
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lesson extends Model
{
    protected $table = 'lesson';

    public $timestamps = false;

    protected $fillable = [
        'trainer_id', 'location_id', 'name', 'description',
        'date', 'start_time', 'end_time', 'max_amount',
    ];

    protected $casts = [
        'date' => 'date',
        'max_amount' => 'integer',
    ];

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(Trainer::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(Participant::class, 'lesson_participant', 'lesson_id', 'participant_id');
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'employee_lesson', 'lesson_id', 'employee_id');
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('lesson.date', '>=', today()->toDateString());
    }

    public function scopeChronological(Builder $query): Builder
    {
        return $query->orderBy('lesson.date')->orderBy('lesson.start_time');
    }

    public function getStartLabelAttribute(): string
    {
        return substr((string) $this->start_time, 0, 5);
    }

    public function getEndLabelAttribute(): string
    {
        return substr((string) $this->end_time, 0, 5);
    }

    /** Aantal vrije plaatsen; gebruikt participants_count als withCount() is gebruikt. */
    public function spotsLeft(): int
    {
        $taken = $this->participants_count ?? $this->participants()->count();

        return max(0, $this->max_amount - $taken);
    }
}

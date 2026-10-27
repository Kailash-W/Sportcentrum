<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Participant extends Model
{
    protected $table = 'participant';

    public $timestamps = false; // de tabel heeft alleen creation_date (met standaardwaarde)

    protected $fillable = ['user_id', 'name', 'address', 'phone'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class, 'lesson_participant', 'participant_id', 'lesson_id');
    }

    /** Is dit lid al ingeschreven voor een andere les die overlapt met deze les? */
    public function hasConflictWith(Lesson $lesson): bool
    {
        return $this->lessons()
            ->where('lesson.id', '!=', $lesson->id)
            ->where('lesson.date', $lesson->date->toDateString())
            ->where('lesson.start_time', '<', $lesson->end_time)
            ->where('lesson.end_time', '>', $lesson->start_time)
            ->exists();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employee extends Model
{
    protected $table = 'employee';

    public $timestamps = false;

    protected $fillable = ['name', 'position'];

    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class, 'employee_lesson', 'employee_id', 'lesson_id');
    }
}

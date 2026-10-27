<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activity';

    public $timestamps = false;

    protected $fillable = ['name', 'description', 'date'];

    protected $casts = [
        'date' => 'date',
    ];
}

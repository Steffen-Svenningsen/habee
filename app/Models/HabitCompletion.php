<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HabitCompletion extends Model
{
    protected $fillable = [
        'habit_id',
        'date',
        'is_completed',
    ];

    protected $casts = [
        'date' => 'date',
        'is_completed' => 'boolean',
    ];
}

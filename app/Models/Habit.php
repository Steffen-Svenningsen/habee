<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function completions()
    {
        return $this->hasMany(HabitCompletion::class);
    }
}

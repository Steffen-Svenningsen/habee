<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'color',
        'icon',
    ];

    public function habits()
    {
        return $this->hasMany(Habit::class);
    }
}

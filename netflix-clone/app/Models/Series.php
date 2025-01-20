<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    public function genres()
    {
        return $this->hasMany(Genre::class);
    }

    public function contents()
    {
        return $this->belongsToMany(Content::class, 'series_episodes');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;

    public function genre()
    {
        return $this->hasOne();
    }

    public function contents()
    {
        return $this->belongsToMany(Content::class, 'series_episodes');
    }
}

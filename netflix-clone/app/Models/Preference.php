<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    use HasFactory;

    public function contents()
    {
        return $this->belongsToMany(Content::class);
    }

    public function profiles()
    {
        return $this->belongsToMany(Profile::class, 'profile_preferences');
    }
}

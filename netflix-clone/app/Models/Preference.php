<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    protected $fillable = [
        'name',
    ];

    public function contents()
    {
        return $this->belongsToMany(Content::class);
    }

    public function profiles()
    {
        return $this->belongsToMany(Profile::class, 'profile_preferences');
    }
}

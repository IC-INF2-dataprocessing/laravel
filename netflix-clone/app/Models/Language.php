<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'name',
    ];

    public function profiles()
    {
        return $this->belongsTo(Profile::class);
    }

    public function subtitles()
    {
        return $this->belongsTo(Subtitle::class);
    }
}

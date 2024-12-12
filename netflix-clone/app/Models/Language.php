<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    public function profiles()
    {
        return $this->belongsTo(Profile::class);
    }

    public function subtitles()
    {
        return $this->belongsTo(Subtitle::class);
    }
}

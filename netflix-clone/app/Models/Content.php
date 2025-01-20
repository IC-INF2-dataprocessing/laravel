<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    public function series()
    {
        return $this->belongsToMany(Series::class, 'series_episodes');
    }

    public function preferences()
    {
        return $this->belongsToMany(Preference::class);
    }

    public function videoQualities()
    {
        return $this->belongsToMany(VideoQuality::class);
    }

    public function profiles()
    {
        return $this->belongsToMany(Profile::class, 'content_progress');
    }
}

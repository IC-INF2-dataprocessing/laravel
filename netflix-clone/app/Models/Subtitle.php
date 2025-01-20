<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subtitle extends Model
{
    protected $fillable = [
        'content_id',
        'language_id',
        'subtitle_path',
    ];

    public function languages()
    {
        return $this->belongsTo(Language::class);
    }

    public function contents()
    {
        return $this->belongsTo(Content::class);
    }
}

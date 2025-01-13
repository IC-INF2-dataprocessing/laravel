<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'date_of_birth',
        'profile_picture',
    ];

    public function accounts()
    {
        $this->belongsTo();
    }

    public function contents()
    {
        return $this->belongsToMany(Content::class, 'content_progress');
    }

    public function preferences()
    {
        return $this->belongsToMany(Preference::class, 'profile_preferences');
    }
}

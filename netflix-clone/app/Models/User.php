<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Fillable attributes for mass assignment
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // Ensure this is included for role assignment
    ];

    // Attributes hidden from array/json serialization
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Attributes cast to native types
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Define the relationship with the Role model.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}

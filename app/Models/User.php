<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $attributes = ['role' => 'user', 'is_active' => true, 'total_xp' => 0];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['password' => 'hashed', 'is_active' => 'boolean', 'total_xp' => 'integer'];

    protected $fillable = ['name', 'email', 'password'];

    public function participations()
    {
        return $this->hasMany(MissionParticipant::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')->withPivot('awarded_at');
    }
}

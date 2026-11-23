<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissionParticipant extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'mission_id', 'status', 'reward_xp_snapshot', 'category_snapshot', 'joined_at', 'completed_at'];

    protected $casts = [
        'draft_photos' => 'array',
        'joined_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function latestSubmission()
    {
        return $this->hasOne(Submission::class, 'participant_id')->latestOfMany('attempt_number');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'participant_id');
    }
}

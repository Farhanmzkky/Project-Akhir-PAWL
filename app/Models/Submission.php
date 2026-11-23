<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $casts = ['submitted_at' => 'datetime', 'reviewed_at' => 'datetime'];

    public $timestamps = false;

    protected $fillable = ['participant_id', 'attempt_number', 'description', 'status', 'reviewed_by', 'rejection_reason', 'submitted_at', 'reviewed_at'];

    public function participant()
    {
        return $this->belongsTo(MissionParticipant::class, 'participant_id');
    }

    public function photos()
    {
        return $this->hasMany(SubmissionPhoto::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionPhoto extends Model
{
    public $timestamps = false;

    protected $fillable = ['submission_id', 'file_path'];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}

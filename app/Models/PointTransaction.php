<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointTransaction extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'participant_id', 'xp_amount', 'type', 'created_at'];
}

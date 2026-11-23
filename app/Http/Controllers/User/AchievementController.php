<?php

namespace App\Http\Controllers\User;

use App\Models\Badge;
use Illuminate\Http\Request;

class AchievementController
{
    public function index(Request $request)
    {
        return view('user.achievements.index', [
            'badges' => Badge::all(),
            'owned' => $request->user()->badges()->pluck('badges.id'),
        ]);
    }
}

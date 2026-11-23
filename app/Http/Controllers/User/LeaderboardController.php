<?php

namespace App\Http\Controllers\User;

use App\Models\User;

class LeaderboardController
{
    public static function ranking()
    {
        return User::where('role', 'user')->where('is_active', true)
            ->withCount(['participations as completed_count' => fn ($q) => $q->where('status', 'completed')])
            ->orderByDesc('total_xp')->orderByDesc('completed_count')->orderBy('id');
    }

    public function index()
    {
        return view('user.leaderboard.index', ['users' => self::ranking()->paginate(20)]);
    }
}

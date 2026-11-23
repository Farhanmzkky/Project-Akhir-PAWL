<?php

namespace App\Http\Controllers\User;

use App\Services\GamificationService;
use Illuminate\Http\Request;

class DashboardController
{
    public function index(Request $request)
    {
        $user = $request->user();
        $level = GamificationService::level($user->total_xp);
        $levels = config('gamification.levels');
        $base = $levels[$level]['min'];
        $next = $levels[$level + 1]['min'] ?? null;
        $progress = $next ? round(100 * ($user->total_xp - $base) / ($next - $base)) : 100;
        $ranking = LeaderboardController::ranking()->get();
        $rank = $ranking->search(fn ($entry) => $entry->id === $user->id) + 1;
        $sessionKey = 'plogee.level_seen.'.$user->id;
        $previous = $request->session()->get($sessionKey, $level);
        $request->session()->put($sessionKey, $level);

        return view('user.dashboard', [
            'user' => $user, 'level' => $level, 'levelName' => $levels[$level]['name'],
            'progress' => $progress, 'next' => $next, 'rank' => $rank, 'levelUp' => $level > $previous,
            'completed' => $user->participations()->where('status', 'completed')->count(),
            'ongoing' => $user->participations()->with('mission')->where('status', '!=', 'completed')->latest('joined_at')->get(),
            'badges' => $user->badges()->latest('user_badges.awarded_at')->limit(3)->get(),
        ]);
    }
}

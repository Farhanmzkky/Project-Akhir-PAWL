<?php

namespace App\Http\Controllers\User;

use App\Models\Mission;
use App\Services\GamificationService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MissionController
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'level' => ['nullable', 'integer', 'between:1,5'],
            'category' => ['nullable', Rule::in(config('gamification.categories'))],
        ]);
        $query = Mission::where('is_active', true);
        if (!empty($filters['level'])) {
            $query->where('required_level', $filters['level']);
        }
        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }
        return view('user.missions.index', [
            'missions' => $query->orderBy('required_level')->orderBy('id')->get(),
            'joined' => $request->user()->participations()->get()->keyBy('mission_id'),
            'level' => GamificationService::level($request->user()->total_xp),
        ]);
    }

    public function show(Request $request, Mission $mission)
    {
        $participation = $request->user()->participations()->where('mission_id', $mission->id)->first();
        abort_unless($mission->is_active || $participation, 404);
        return view('user.missions.show', [
            'mission' => $mission, 'participation' => $participation,
            'level' => GamificationService::level($request->user()->total_xp),
        ]);
    }
}

<?php

namespace App\Services;

use App\Models\Mission;
use App\Models\MissionParticipant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MissionService
{
    public function join(User $user, Mission $mission): MissionParticipant
    {
        return DB::transaction(function () use ($user, $mission) {
            $user = User::lockForUpdate()->findOrFail($user->id);
            $mission = Mission::lockForUpdate()->findOrFail($mission->id);
            abort_unless($user->is_active, 403);
            $existing = $user->participations()->where('mission_id', $mission->id)->first();
            if ($existing) {
                return $existing;
            }
            if (!$mission->is_active || GamificationService::level($user->total_xp) < $mission->required_level) {
                throw ValidationException::withMessages(['mission' => 'Misi ini belum dapat diikuti.']);
            }

            return $user->participations()->create([
                'mission_id' => $mission->id,
                'status' => 'in_progress',
                'reward_xp_snapshot' => $mission->xp_reward,
                'category_snapshot' => $mission->category,
                'joined_at' => now(),
            ]);
        }, 3);
    }
}

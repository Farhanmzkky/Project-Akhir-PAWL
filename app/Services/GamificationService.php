<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\MissionParticipant;
use App\Models\PointTransaction;
use App\Models\User;

class GamificationService
{
    public static function level(int $xp): int
    {
        $level = 1;
        foreach (config('gamification.levels') as $number => $settings) {
            if ($xp >= $settings['min']) {
                $level = $number;
            }
        }
        return $level;
    }

    // Dipanggil dalam transaksi keputusan admin dengan baris peserta terkunci.
    public function award(User $user, MissionParticipant $participant): void
    {
        PointTransaction::create([
            'user_id' => $user->id, 'participant_id' => $participant->id,
            'xp_amount' => $participant->reward_xp_snapshot, 'created_at' => now(),
        ]);
        $user->increment('total_xp', $participant->reward_xp_snapshot);

        $completed = $user->participations()->where('status', 'completed')->get(['category_snapshot']);
        $values = [
            'completed' => $completed->count(),
            'level' => self::level($user->total_xp),
            'community' => $completed->where('category_snapshot', 'Komunitas')->count(),
            'recycling' => $completed->where('category_snapshot', 'Daur ulang')->count(),
        ];
        $owned = $user->badges()->pluck('badges.id');
        foreach (Badge::all() as $badge) {
            if (!$owned->contains($badge->id) && ($values[$badge->criteria_key] ?? 0) >= $badge->criteria_value) {
                $user->badges()->attach($badge->id, ['awarded_at' => now()]);
            }
        }
    }
}

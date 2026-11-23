<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    protected $fillable = ['seed_key', 'title', 'description', 'category', 'required_level', 'xp_reward', 'evidence_instructions', 'is_active'];

    public function getDisplayTitleAttribute(): string
    {
        return match ($this->title) {
            'Bring Your Tumbler' => 'Bawa tumbler sendiri',
            'Say No to Plastic' => 'Belanja tanpa plastik',
            'Trash in Its Place' => 'Pilah sampah di rumah',
            default => $this->title,
        };
    }

    public function participants()
    {
        return $this->hasMany(MissionParticipant::class);
    }
}

<article class="bg-white border border-line rounded-container overflow-hidden shadow-[0_6px_0_rgba(38,62,48,0.05)] flex flex-col justify-between transition-all hover:translate-y-[-2px]">
    <div>
        @include('components.art', ['category' => $mission->category])
        <div class="p-5 flex flex-col gap-2">
            <span class="text-caption text-muted uppercase tracking-wider font-semibold">Level {{ $mission->required_level }} · {{ $mission->category }}</span>
            <h2 class="text-section text-ink hover:text-forest transition-colors">
                <a href="{{ route('user.missions.show', $mission) }}">{{ $mission->display_title }}</a>
            </h2>
            <p class="text-body text-muted line-clamp-2">{{ $mission->description }}</p>
        </div>
    </div>
    <div class="p-5 pt-0 flex items-center justify-between border-t border-line/50 mt-2">
        <span class="text-label font-bold text-forest bg-lime/40 px-3 py-1 rounded-full">+{{ $participation?->reward_xp_snapshot ?? $mission->xp_reward }} XP</span>
        @include('components.status', ['status' => $participation?->status ?? ($level < $mission->required_level ? 'locked' : 'available')])
    </div>
</article>

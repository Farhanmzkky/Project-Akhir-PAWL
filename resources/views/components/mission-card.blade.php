<article class="panel mission-card">
    @include('components.art', ['category' => $mission->category])
    <div class="card-body"><small>Level {{ $mission->required_level }} · {{ $mission->category }}</small>
    <h2><a href="{{ route('user.missions.show', $mission) }}">{{ $mission->display_title }}</a></h2>
    <p>{{ $mission->description }}</p>
    <div class="spread"><strong>+{{ $participation?->reward_xp_snapshot ?? $mission->xp_reward }} XP</strong>
        @include('components.status', ['status' => $participation?->status ?? ($level < $mission->required_level ? 'locked' : 'available')])
    </div></div>
</article>

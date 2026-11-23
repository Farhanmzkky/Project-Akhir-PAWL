@php
    $items = $admin ? [
        ['admin.dashboard', 'Dashboard', 'home', 'admin.dashboard'],
        ['admin.missions.index', 'Kelola misi', 'flag', 'admin.missions.*'],
        ['admin.submissions.index', 'Antrean bukti', 'grid-icon', 'admin.submissions.index'],
        ['admin.submissions.history', 'Riwayat verifikasi', 'cup', 'admin.submissions.history'],
        ['admin.users.index', 'Kelola peserta', 'home', 'admin.users.*'],
    ] : [
        ['user.dashboard', 'Dashboard', 'home', 'user.dashboard'],
        ['user.missions.index', 'Jelajahi misi', 'flag', 'user.missions.*'],
        ['user.my-missions', 'Misi saya', 'grid-icon', 'user.my-missions'],
        ['user.achievements', 'Kebunku', 'cup', 'user.achievements'],
    ];
@endphp
<aside class="rail">
    <a class="brand" href="{{ route('home') }}"><i class="glyph leaf" aria-hidden="true"></i>plogee</a>
    <div class="space-name">{{ $admin ? 'Admin space' : 'Member space' }}</div>
    <nav class="rail-nav" aria-label="Menu utama">
        @foreach($items as [$name, $label, $icon, $pattern])
            <a href="{{ route($name) }}" @if(request()->routeIs($pattern) || ($name === 'user.my-missions' && request()->routeIs('user.evidence'))) aria-current="page" @endif>
                <i class="glyph {{ $icon }} " aria-hidden="true"></i>{{ $label }}
            </a>
        @endforeach
    </nav>
    <div class="rail-foot">
        <div class="rail-note"><i class="glyph leaf" aria-hidden="true"></i><strong>Aksi kecil.<br>Dampak besar.</strong><small>Setiap misi adalah langkah untuk bumi.</small></div>
        <div class="rail-person"><span class="avatar">{{ $initials }}</span><div><strong>{{ $account->name }}</strong>
            @if($admin)<small>Administrator</small>
            @else
                @php
                    $memberLevel = \App\Services\GamificationService::level($account->total_xp);
                @endphp
                <small>Level {{ $memberLevel }} · {{ config("gamification.levels.$memberLevel.name") }}</small>
            @endif
        </div></div>
    </div>
</aside>

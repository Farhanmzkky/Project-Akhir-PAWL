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

<aside class="w-[224px] bg-white border-r border-line flex flex-col px-6 py-8 min-h-screen shrink-0">
    <!-- Brand -->
    <a class="inline-flex items-center gap-2.5 text-2xl font-extrabold tracking-tight text-ink" href="{{ route('home') }}">
        <i class="glyph leaf w-8 h-8 text-forest" aria-hidden="true"></i>
        <span>plogee</span>
    </a>

    <!-- Space badge -->
    <div class="self-start mt-3 mb-6 px-3 py-1 rounded-full bg-soft text-forest uppercase font-medium text-caption">
        {{ $admin ? 'Admin space' : 'Member space' }}
    </div>

    <!-- Navigation links -->
    <nav class="flex flex-col gap-2" aria-label="Menu utama">
        @foreach($items as [$name, $label, $icon, $pattern])
            @php
                $isActive = request()->routeIs($pattern) || ($name === 'user.my-missions' && request()->routeIs('user.evidence'));
            @endphp
            <a href="{{ route($name) }}"
               class="flex items-center gap-3 min-h-[48px] px-3.5 py-2.5 rounded-btn text-label transition-colors {{ $isActive ? 'bg-forest text-white font-semibold' : 'text-muted hover:bg-soft' }}"
               @if($isActive) aria-current="page" @endif>
                <i class="glyph {{ $icon }} {{ $isActive ? 'text-lime' : 'text-muted' }}" aria-hidden="true"></i>
                <span>{{ $label }}</span>
            </a>
        @endforeach
    </nav>

    <!-- Rail Footer -->
    <div class="mt-auto pt-10 flex flex-col gap-6">
        <div class="p-4 bg-soft text-forest rounded-container flex flex-col gap-3">
            <i class="glyph leaf text-forest" aria-hidden="true"></i>
            <div>
                <strong class="text-label leading-tight block">Aksi kecil.<br>Dampak besar.</strong>
                <small class="text-caption text-forest/80 block mt-1">Setiap misi adalah langkah untuk bumi.</small>
            </div>
        </div>

        <div class="flex items-center gap-3 pt-2 border-t border-line/60">
            <span class="w-10 h-10 rounded-full bg-soft text-forest font-semibold text-label flex items-center justify-center shrink-0">
                {{ $initials }}
            </span>
            <div class="min-w-0">
                <strong class="text-label text-ink block truncate">{{ $account->name }}</strong>
                @if($admin)
                    <small class="text-caption text-muted block">Administrator</small>
                @else
                    @php
                        $memberLevel = \App\Services\GamificationService::level($account->total_xp);
                    @endphp
                    <small class="text-caption text-muted block">Level {{ $memberLevel }} · {{ config("gamification.levels.$memberLevel.name") }}</small>
                @endif
            </div>
        </div>
    </div>
</aside>

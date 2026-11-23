<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Ruang hijau') · Plogee</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/plogee.css') }}" rel="stylesheet">
</head>
<body>
@auth
    @php
        $account = auth()->user();
        $admin = $account->role === 'admin';
        $initials = collect(preg_split('/\s+/u', trim($account->name), -1, PREG_SPLIT_NO_EMPTY))
            ->take(2)->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))->implode('');
    @endphp
    <div class="app-shell">
        @include('components.sidebar')
        <div class="app-column">
            <header class="member-header">
                <div class="breadcrumb-line">{{ $admin ? 'Ruang admin' : 'Ruang hijau' }} <span>/</span> @yield('title', 'Dashboard')</div>
                <div class="header-tools">
                    <time datetime="{{ now('Asia/Jakarta')->toDateString() }}">{{ now('Asia/Jakarta')->locale('id')->isoFormat('dddd, D MMM YYYY') }}</time>
                    <a class="icon-control" aria-label="{{ $admin ? 'Buka antrean bukti' : 'Lihat misi yang perlu perbaikan' }}"
                        href="{{ $admin ? route('admin.submissions.index') : route('user.my-missions', ['status' => 'rejected']) }}"><i class="glyph bell" aria-hidden="true"></i></a>
                    <details class="account-menu"><summary aria-label="Menu akun {{ $account->name }}"><span class="avatar">{{ $initials }}</span></summary>
                        <div class="account-pop"><strong>{{ $account->name }}</strong>
                        @unless($admin)<a href="{{ route('user.profile') }}">Profil saya</a>@endunless
                        <form method="post" action="{{ route('logout') }}">@csrf <button class="linklike">Keluar</button></form></div>
                    </details>
                </div>
            </header>
            <main class="stage" id="content">@include('components.alert') @yield('content')</main>
        </div>
    </div>
@else
    <header class="topbar"><a class="brand" href="{{ route('landing') }}"><i class="glyph leaf" aria-hidden="true"></i>plogee</a>
        <nav><a href="{{ route('login') }}">Masuk</a><a class="action" href="{{ route('register') }}">Daftar</a></nav>
    </header>
    <div class="public-wrap"><main>@include('components.alert') @yield('content')</main></div>
    <footer>Plogee · Ruang hijau</footer>
@endauth
@stack('scripts')
</body>
</html>

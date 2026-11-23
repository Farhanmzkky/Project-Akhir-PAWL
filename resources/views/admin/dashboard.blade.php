@extends('layouts.app')
@section('title', 'Dashboard admin')
@section('content')
<h1>Dashboard admin</h1>
<div class="grid cards">
@foreach(['Peserta terdaftar' => $userCount, 'Misi aktif' => $activeMissions, 'Misi selesai' => $counts->get('approved', 0), 'Menunggu verifikasi' => $counts->get('pending', 0), 'XP diberikan' => $xp] as $label => $value)
    <section class="panel"><h2>{{ $label }}</h2><p class="big">{{ number_format($value, 0, ',', '.') }}</p></section>
@endforeach
</div>
<section class="panel"><div class="spread"><h2>Status pengiriman bukti</h2><a href="{{ route('admin.submissions.index') }}">Periksa antrean →</a></div>
    <p>Menunggu {{ $counts->get('pending', 0) }} · Disetujui {{ $counts->get('approved', 0) }} · Ditolak {{ $counts->get('rejected', 0) }}</p>
    <div class="chart"><canvas id="reviews" aria-label="Jumlah pengiriman menurut status" role="img"></canvas></div>
</section>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.8/dist/chart.umd.min.js"></script>
<script>
    const chart = document.getElementById('reviews');
    if (window.Chart) {
        new Chart(chart, {
            type: 'bar',
            data: { labels: ['Menunggu', 'Disetujui', 'Ditolak'], datasets: [{
                label: 'Pengiriman', data: [{{ (int) $counts->get('pending', 0) }}, {{ (int) $counts->get('approved', 0) }}, {{ (int) $counts->get('rejected', 0) }}],
                backgroundColor: ['#dcae54', '#257259', '#b96552'], borderRadius: 7,
            }] },
            options: { maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
        });
    } else {
        chart.parentElement.hidden = true;
    }
</script>
@endpush
@endsection

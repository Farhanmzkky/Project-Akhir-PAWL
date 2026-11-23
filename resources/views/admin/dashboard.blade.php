@extends('layouts.app')
@section('title', 'Dashboard admin')
@section('content')
<h1 class="text-heading text-ink mb-6 anim-fade-up">Dashboard admin</h1>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
@foreach([
    'Peserta terdaftar' => $userCount,
    'Misi aktif' => $activeMissions,
    'Misi selesai' => $counts->get('approved', 0),
    'Menunggu verifikasi' => $counts->get('pending', 0),
    'XP diberikan' => $xp
] as $label => $value)
    <section class="bg-white border border-line rounded-container p-5 shadow-[0_6px_0_rgba(38,62,48,0.05)]
                    card-hover row-anim"
             style="animation-delay: {{ $loop->index * 0.07 }}s">
        <span class="text-caption text-muted uppercase font-semibold tracking-wider block">{{ $label }}</span>
        <p class="text-3xl font-extrabold text-ink mt-2 stat-bounce">{{ number_format($value, 0, ',', '.') }}</p>
    </section>
@endforeach
</div>

<!-- Review Queue Chart & Activity -->
<section class="bg-white border border-line rounded-container p-6 shadow-[0_6px_0_rgba(38,62,48,0.05)] anim-fade-up delay-5">
    <div class="flex items-center justify-between gap-4 mb-4">
        <div>
            <h2 class="text-section text-ink">Status pengiriman bukti</h2>
            <p class="text-body text-muted mt-0.5">
                Menunggu: <strong class="text-[#F5C563]">{{ $counts->get('pending', 0) }}</strong> ·
                Disetujui: <strong class="text-[#92DEB4]">{{ $counts->get('approved', 0) }}</strong> ·
                Ditolak: <strong class="text-[#FFAB98]">{{ $counts->get('rejected', 0) }}</strong>
            </p>
        </div>
        <x-action :href="route('admin.submissions.index')" onclick="window.location='{{ route('admin.submissions.index') }}'">
            Periksa antrean →
        </x-action>
    </div>

    <div class="h-64 w-full mt-6">
        <canvas id="reviews" aria-label="Jumlah pengiriman menurut status" role="img"></canvas>
    </div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.8/dist/chart.umd.min.js"></script>
<script>
    const chart = document.getElementById('reviews');
    if (window.Chart && chart) {
        new Chart(chart, {
            type: 'bar',
            data: {
                labels: ['Menunggu review', 'Disetujui', 'Perlu perbaikan'],
                datasets: [{
                    label: 'Pengiriman',
                    data: [{{ (int) $counts->get('pending', 0) }}, {{ (int) $counts->get('approved', 0) }}, {{ (int) $counts->get('rejected', 0) }}],
                    backgroundColor: ['#F5C563', '#183F32', '#903E35'],
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: { duration: 900, easing: 'easeOutQuart' },
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                }
            }
        });
    }
</script>
@endpush
@endsection

@php
    $labels = [
        'locked' => 'Terkunci', 'available' => 'Tersedia', 'in_progress' => 'Berlangsung',
        'pending_review' => 'Menunggu review', 'pending' => 'Menunggu review',
        'approved' => 'Disetujui', 'completed' => 'Disetujui', 'rejected' => 'Perlu perbaikan',
    ];
@endphp
<span class="pill {{ $status }}">{{ $labels[$status] ?? $status }}</span>

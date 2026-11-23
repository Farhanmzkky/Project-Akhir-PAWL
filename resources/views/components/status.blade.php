@php
    $config = [
        'in_progress' => ['label' => 'Berlangsung', 'color' => 'text-[#93CFF1]'],
        'pending' => ['label' => 'Menunggu review', 'color' => 'text-[#F5C563]'],
        'pending_review' => ['label' => 'Menunggu review', 'color' => 'text-[#F5C563]'],
        'approved' => ['label' => 'Disetujui', 'color' => 'text-[#92DEB4]'],
        'completed' => ['label' => 'Disetujui', 'color' => 'text-[#92DEB4]'],
        'rejected' => ['label' => 'Perlu perbaikan', 'color' => 'text-[#FFAB98]'],
        'locked' => ['label' => 'Terkunci', 'color' => 'text-[#A0A0A0]'],
        'available' => ['label' => 'Tersedia', 'color' => 'text-[#92DEB4]'],
    ];

    $item = $config[$status] ?? ['label' => ucfirst($status), 'color' => 'text-white'];
@endphp

<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#111111] text-caption font-medium {{ $item['color'] }}">
    <span class="w-1.5 h-1.5 rounded-full bg-current opacity-75"></span>
    {{ $item['label'] }}
</span>

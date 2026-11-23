@php
    $images = [
        'Kebiasaan' => 'kebiasaan',
        'Daur ulang' => 'daur-ulang',
        'Komunitas' => 'komunitas',
        'Proyek' => 'proyek'
    ];
@endphp
<img class="w-full h-32 object-cover rounded-t-[22px]" src="{{ asset('images/'.($images[$category] ?? 'proyek').'.png') }}" alt="" loading="lazy">

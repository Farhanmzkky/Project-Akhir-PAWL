@php
    $images = ['Kebiasaan' => 'kebiasaan', 'Daur ulang' => 'daur-ulang', 'Komunitas' => 'komunitas', 'Proyek' => 'proyek'];
@endphp
<img class="mission-art" src="{{ asset('images/'.($images[$category] ?? 'proyek').'.png') }}" alt="" loading="lazy">

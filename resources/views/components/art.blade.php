@php
    $pool = [
        'alam.png',
        'belanja.png',
        'bertumbuh.png',
        'daur-ulang.png',
        'flag.png',
        'plastik.png'
    ];

    // Jika ada mission ID, seed_key, atau title, tentukan indeks secara konsisten tapi terdistribusi acak
    if (isset($mission) && $mission) {
        $key = $mission->id ?? crc32($mission->title ?? $mission->seed_key ?? 'plogee');
        $selectedImage = $pool[abs(intval($key)) % count($pool)];
    } elseif (isset($seed)) {
        $selectedImage = $pool[abs(intval(crc32((string)$seed))) % count($pool)];
    } else {
        $selectedImage = $pool[array_rand($pool)];
    }
@endphp
<img class="w-full h-32 object-cover rounded-t-[22px]" src="{{ asset('images/' . $selectedImage) }}" alt="Ilustrasi misi" loading="lazy">

<div class="flex gap-3 flex-wrap">
@foreach($submission->photos as $photo)
    <a href="{{ route('photos.show', $photo) }}" target="_blank" rel="noopener" class="block w-24 h-24 rounded-xl overflow-hidden border border-line hover:opacity-90 transition-opacity">
        <img src="{{ route('photos.show', $photo) }}" loading="lazy" class="w-full h-full object-cover" alt="Bukti kegiatan, foto {{ $loop->iteration }}">
    </a>
@endforeach
</div>

<div class="photos">
@foreach($submission->photos as $photo)
    <a href="{{ route('photos.show', $photo) }}" target="_blank" rel="noopener">
        <img src="{{ route('photos.show', $photo) }}" loading="lazy" alt="Bukti kegiatan, foto {{ $loop->iteration }}">
    </a>
@endforeach
</div>

@extends('layouts.app')
@section('title', 'Aksi lingkungan di kampus')
@section('content')
<section class="hero">
    <div><p class="kicker">Misi lingkungan kampus</p>
        <h1>Mulai dari satu aksi kecil.</h1>
        <p>Pilih misi yang dekat dengan keseharianmu. Dokumentasikan aksimu, kumpulkan XP, dan buka tantangan berikutnya.</p>
        <a class="action" href="{{ auth()->check() ? route('home') : route('register') }}">{{ auth()->check() ? 'Buka dashboard' : 'Mulai misi pertamaku' }}</a>
    </div>
    <img src="{{ asset('images/komunitas.png') }}" alt="Ilustrasi bibit yang tumbuh di perbukitan hijau">
</section>
<section class="grid three steps">
    <article><h2>Pilih misi</h2><p>Mulai dari Eco Beginner. Empat misi pertama tersedia sejak kamu bergabung.</p></article>
    <article><h2>Kirim bukti</h2><p>Ceritakan kegiatanmu dan unggah satu sampai tiga foto.</p></article>
    <article><h2>Kumpulkan XP</h2><p>Setelah bukti disetujui, lihat perubahan level, badge, dan peringkatmu.</p></article>
</section>
@endsection

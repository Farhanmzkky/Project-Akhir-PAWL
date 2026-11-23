@extends('layouts.app')
@section('title', 'Aksi lingkungan di kampus')
@section('content')
<section class="bg-soft border border-line rounded-container overflow-hidden grid grid-cols-1 md:grid-cols-2 items-center">
    <div class="p-8 lg:p-14 flex flex-col gap-4">
        <span class="text-caption font-bold text-forest uppercase tracking-widest">Misi lingkungan kampus</span>
        <h1 class="text-4xl lg:text-5xl font-extrabold text-ink tracking-tight leading-tight">Mulai dari satu aksi kecil.</h1>
        <p class="text-body text-muted max-w-md">Pilih misi yang dekat dengan keseharianmu. Dokumentasikan aksimu, kumpulkan XP, dan buka tantangan berikutnya.</p>
        <div class="pt-2">
            <x-action :href="auth()->check() ? route('home') : route('register')" onclick="window.location='{{ auth()->check() ? route('home') : route('register') }}'">
                {{ auth()->check() ? 'Buka dashboard' : 'Mulai misi pertamaku' }}
            </x-action>
        </div>
    </div>
    <div class="h-full min-h-[280px]">
        <img class="w-full h-full object-cover" src="{{ asset('images/komunitas.png') }}" alt="Ilustrasi bibit yang tumbuh di perbukitan hijau">
    </div>
</section>

<section class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
    <article class="bg-white border border-line rounded-container p-6 shadow-[0_6px_0_rgba(38,62,48,0.05)] border-t-4 border-t-forest">
        <h2 class="text-section text-ink mb-2">Pilih misi</h2>
        <p class="text-body text-muted">Mulai dari Eco Beginner. Empat misi pertama tersedia sejak kamu bergabung.</p>
    </article>
    <article class="bg-white border border-line rounded-container p-6 shadow-[0_6px_0_rgba(38,62,48,0.05)] border-t-4 border-t-forest">
        <h2 class="text-section text-ink mb-2">Kirim bukti</h2>
        <p class="text-body text-muted">Ceritakan kegiatanmu dan unggah satu sampai tiga foto aksi nyata.</p>
    </article>
    <article class="bg-white border border-line rounded-container p-6 shadow-[0_6px_0_rgba(38,62,48,0.05)] border-t-4 border-t-forest">
        <h2 class="text-section text-ink mb-2">Kumpulkan XP</h2>
        <p class="text-body text-muted">Setelah bukti disetujui, lihat perubahan level, badge, dan peringkatmu.</p>
    </article>
</section>
@endsection

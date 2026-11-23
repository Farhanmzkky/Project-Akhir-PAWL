@extends('layouts.app')
@section('title', 'Masuk ke Plogee')
@section('content')
<div class="max-w-md mx-auto bg-white border border-line rounded-container p-8 shadow-[0_6px_0_rgba(38,62,48,0.05)] anim-scale">
    <h1 class="text-heading text-ink mb-6">Masuk ke Plogee</h1>
    <form class="flex flex-col gap-4" method="POST" action="{{ route('login.store') }}">
        @csrf
        <div class="anim-fade-up delay-1"><x-field name="email" type="email" label="Email" autocomplete="email" /></div>
        <div class="anim-fade-up delay-2"><x-field name="password" type="password" label="Kata sandi" autocomplete="current-password" /></div>
        <div class="pt-2 anim-fade-up delay-3">
            <x-action class="w-full">Masuk</x-action>
        </div>
    </form>
    <p class="text-body text-muted mt-6 text-center anim-fade delay-4">
        Belum punya akun? <a class="text-forest font-semibold hover:underline" href="{{ route('register') }}">Daftar sebagai peserta</a>
    </p>
</div>
@endsection

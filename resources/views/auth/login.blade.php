@extends('layouts.app')
@section('title', 'Masuk ke Plogee')
@section('content')
<div class="max-w-md mx-auto bg-white border border-line rounded-container p-8 shadow-[0_6px_0_rgba(38,62,48,0.05)]">
    <h1 class="text-heading text-ink mb-6">Masuk ke Plogee</h1>
    <form class="flex flex-col gap-4" method="POST" action="{{ route('login.store') }}">
        @csrf
        <x-field name="email" type="email" label="Email" autocomplete="email" />
        <x-field name="password" type="password" label="Kata sandi" autocomplete="current-password" />
        <div class="pt-2">
            <x-action class="w-full">Masuk</x-action>
        </div>
    </form>
    <p class="text-body text-muted mt-6 text-center">
        Belum punya akun? <a class="text-forest font-semibold hover:underline" href="{{ route('register') }}">Daftar sebagai peserta</a>
    </p>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Buat akun peserta')
@section('content')
<div class="max-w-md mx-auto bg-white border border-line rounded-container p-8 shadow-[0_6px_0_rgba(38,62,48,0.05)]">
    <h1 class="text-heading text-ink mb-6">Buat akun peserta</h1>
    <form class="flex flex-col gap-4" method="POST" action="{{ route('register.store') }}">
        @csrf
        <x-field name="name" label="Nama lengkap" autocomplete="name" maxlength="80" />
        <x-field name="email" type="email" label="Email" autocomplete="email" />
        <x-field name="password" type="password" label="Kata sandi (minimal 8 karakter)" autocomplete="new-password" />
        <x-field name="password_confirmation" type="password" label="Ulangi kata sandi" autocomplete="new-password" />
        <div class="pt-2">
            <x-action class="w-full">Daftar</x-action>
        </div>
    </form>
    <p class="text-body text-muted mt-6 text-center">
        Sudah punya akun? <a class="text-forest font-semibold hover:underline" href="{{ route('login') }}">Masuk</a>
    </p>
</div>
@endsection

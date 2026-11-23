@extends('layouts.app')
@section('title', 'Buat akun peserta')
@section('content')
<div class="panel narrow"><h1>Buat akun peserta</h1>
<form class="form-stack" method="POST" action="{{ route('register.store') }}">
    @csrf
    <x-field name="name" label="Nama lengkap" autocomplete="name" maxlength="80" />
    <x-field name="email" type="email" label="Email" autocomplete="email" />
    <x-field name="password" type="password" label="Kata sandi (minimal 8 karakter)" autocomplete="new-password" />
    <x-field name="password_confirmation" type="password" label="Ulangi kata sandi" autocomplete="new-password" />
    <x-action>Daftar</x-action>
</form><p class="after">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p></div>
@endsection

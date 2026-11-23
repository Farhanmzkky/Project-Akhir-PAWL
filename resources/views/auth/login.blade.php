@extends('layouts.app')
@section('title', 'Masuk ke Plogee')
@section('content')
<div class="panel narrow"><h1>Masuk ke Plogee</h1>
<form class="form-stack" method="POST" action="{{ route('login.store') }}">
    @csrf
    <x-field name="email" type="email" label="Email" autocomplete="email" />
    <x-field name="password" type="password" label="Kata sandi" autocomplete="current-password" />
    <x-action>Masuk</x-action>
</form><p class="after">Belum punya akun? <a href="{{ route('register') }}">Daftar sebagai peserta</a></p></div>
@endsection

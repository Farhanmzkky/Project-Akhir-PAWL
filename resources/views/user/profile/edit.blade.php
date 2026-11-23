@extends('layouts.app')
@section('title', 'Profil saya')
@section('content')
<h1>Profil saya</h1><form class="panel form-stack narrow" method="POST" action="{{ route('user.profile.update') }}">
    @csrf @method('PUT')
    <x-field name="name" label="Nama lengkap" :value="auth()->user()->name" maxlength="80" />
    <x-field name="email" type="email" label="Email" :value="auth()->user()->email" />
    <x-action>Simpan profil</x-action>
</form>
@endsection

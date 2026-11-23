@extends('layouts.app')
@section('title', 'Kebunku')
@section('content')
<h1>Kebunku</h1><p>{{ $owned->count() }} dari {{ $badges->count() }} badge terbuka.</p>
<div class="grid cards">@foreach($badges as $badge)
<article @class(['panel', 'muted-card' => !$owned->contains($badge->id)])>
    <span class="emblem" aria-hidden="true">{{ $badge->icon }}</span>
    <h2>{{ $badge->name }}</h2><p>{{ $badge->description }}</p>
    <small>{{ $owned->contains($badge->id) ? 'Sudah diperoleh' : 'Masih terkunci' }}</small>
</article>@endforeach</div>
@endsection

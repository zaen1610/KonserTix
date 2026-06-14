Keluaran

@extends('layouts.app')

@section('content')

<div class="hero">

<h1>

🎫 Portal Pengguna

</h1>

<p>

Selamat datang
{{ auth()->user()->name }}

</p>

</div>

<div class="row">

@foreach($events as $event)

<div class="col-md-4 mb-4">

<div class="card-neon">

<h3>

{{ $event->nama_event }}

</h3>

<hr>

<p>

Kategori :
{{ $event->kategori->nama_kategori ?? '-' }}

</p>

<p>

Lokasi :
{{ $event->lokasi->nama_lokasi ?? '-' }}

</p>

<p>

Tanggal :
{{ $event->tanggal }}

</p>

<a
href="{{ route('tiket.index') }}"
class="btn btn-neon">

Lihat Tiket

</a>

</div>

</div>

@endforeach

</div>

@endsection

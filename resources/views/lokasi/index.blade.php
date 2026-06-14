@extends('layouts.app')

@section('content')

<div class="hero">

    <h1>📍 Lokasi Konser</h1>

    <p>
        Kelola venue dan lokasi event konser
    </p>

</div>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2>🏟 Data Lokasi</h2>

        <p class="text-secondary">
            Semua lokasi yang digunakan oleh event
        </p>
    </div>

    <div>
        <a href="{{ route('lokasi.create') }}"
           class="btn btn-neon">

            + Tambah Lokasi

        </a>
    </div>

</div>

<div class="row">

@forelse($lokasis as $lokasi)

@php

$totalEvent = $lokasi->events->count();

$totalTiket = 0;

$totalPendapatan = 0;

foreach($lokasi->events as $event){

    foreach($event->tikets as $tiket){

        $totalTiket +=
        $tiket->transaksis->sum('jumlah');

        $totalPendapatan +=
        $tiket->transaksis->sum('total_harga');
    }
}

@endphp

<div class="col-md-6 mb-4">

<div class="card-neon">

<h3>

{{ $lokasi->nama_lokasi }}

</h3>

<p>

<strong>Alamat :</strong><br>

{{ $lokasi->alamat }}

</p>

<p>

<strong>Kapasitas :</strong>

{{ number_format($lokasi->kapasitas) }} Orang

</p>

<hr>

<p>

🎫 Tiket Terjual :
<strong>

{{ $totalTiket }}

</strong>

</p>

<p>

🎵 Total Event :
<strong>

{{ $totalEvent }}

</strong>

</p>

<p>

💰 Pendapatan :
<strong>

Rp {{ number_format($totalPendapatan,0,',','.') }}

</strong>

</p>

<div class="d-flex gap-2">

<a href="{{ route('lokasi.show',$lokasi->id) }}"
   class="btn btn-info">

Detail

</a>

<a href="{{ route('lokasi.edit',$lokasi->id) }}"
   class="btn btn-warning">

Edit

</a>

<form action="{{ route('lokasi.destroy',$lokasi->id) }}"
      method="POST">

    @csrf
    @method('DELETE')

    <button
        class="btn btn-danger"
        onclick="return confirm('Hapus lokasi?')">

        Hapus

    </button>

</form>

</div>

</div>

</div>

@empty

<div class="col-12">

<div class="alert alert-warning">

Belum ada data lokasi.

</div>

</div>

@endforelse

</div>

<br>

<div class="card-neon">

<h3>

📊 Statistik Lokasi

</h3>

<br>

<div class="row">

<div class="col-md-3">

<div class="card bg-dark p-3">

<h5>Total Lokasi</h5>

<h1>

{{ $lokasis->count() }}

</h1>

</div>

</div>

<div class="col-md-3">

<div class="card bg-dark p-3">

<h5>Total Event</h5>

<h1>

{{ \App\Models\Event::count() }}

</h1>

</div>

</div>

<div class="col-md-3">

<div class="card bg-dark p-3">

<h5>Tiket Terjual</h5>

<h1>

{{ \App\Models\Transaksi::sum('jumlah') }}

</h1>

</div>

</div>

<div class="col-md-3">

<div class="card bg-dark p-3">

<h5>Pendapatan</h5>

<h1>

Rp {{ number_format(\App\Models\Transaksi::sum('total_harga'),0,',','.') }}

</h1>

</div>

</div>

</div>

</div>

@endsection
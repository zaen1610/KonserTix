@extends('layouts.app')

@section('content')

<div class="hero">

    <h1>🎵 Kategori Event</h1>

    <p>
        Kelola kategori konser dan jenis event
    </p>

</div>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2>📂 Kategori Konser</h2>

        <p class="text-secondary">
            Kelola semua kategori event konser
        </p>
    </div>

    <div>
        <a href="{{ route('kategori.create') }}"
           class="btn btn-neon">

            + Tambah Kategori

        </a>
    </div>

</div>

<div class="row">

@forelse($kategoris as $kategori)

@php

$totalEvent = $kategori->events->count();

$totalTiket = 0;

$totalPendapatan = 0;

foreach($kategori->events as $event){

    foreach($event->tikets as $tiket){

        $totalTiket +=
        $tiket->transaksis->sum('jumlah');

        $totalPendapatan +=
        $tiket->transaksis->sum('total_harga');
    }
}

@endphp

<div class="col-md-4 mb-4">

<div class="card-neon">

<div class="d-flex justify-content-between">

<div>

<h3>

{{ $kategori->nama_kategori }}

</h3>

<p>
Event Aktif :
<strong>
{{ $totalEvent }}
</strong>
</p>

<p>
Tiket Terjual :
<strong>
{{ $totalTiket }}
</strong>
</p>

<p>
Pendapatan :
<strong>
Rp {{ number_format($totalPendapatan,0,',','.') }}
</strong>
</p>

</div>

<div>

<span class="badge bg-success">

Aktif

</span>

</div>

</div>

<hr>

<div class="d-flex gap-2">

<a href="{{ route('kategori.show',$kategori->id) }}"
   class="btn btn-info">

👁 Detail

</a>

<a href="{{ route('kategori.edit',$kategori->id) }}"
   class="btn btn-warning">

✏ Edit

</a>

<form
action="{{ route('kategori.destroy',$kategori->id) }}"
method="POST">

@csrf
@method('DELETE')

<button
type="submit"
class="btn btn-danger"
onclick="return confirm('Hapus kategori?')">

🗑 Hapus

</button>

</form>

</div>

</div>

</div>

@empty

<div class="col-12">

<div class="alert alert-warning">

Belum ada kategori.

</div>

</div>

@endforelse

</div>

<br>

<div class="card-neon">

<h3>

📊 Statistik Kategori

</h3>

<br>

<div class="row">

<div class="col-md-3">

<div class="card bg-dark p-3">

<h5>Total Kategori</h5>

<h1>

{{ $kategoris->count() }}

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
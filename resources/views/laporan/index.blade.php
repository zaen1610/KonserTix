@extends('layouts.app')

@section('content')

<h2>📊 Laporan Penjualan</h2>

<div class="card-neon">

    <h3>Total Pendapatan</h3>

    <h1>
        Rp {{ number_format($totalPendapatan,0,',','.') }}
    </h1>

    <hr>

    <h3>Tiket Terjual</h3>

    <h1>
        {{ $totalTiket }}
    </h1>

    <br>

    <a href="{{ route('laporan.pdf') }}"
       class="btn btn-neon">

        Cetak PDF

    </a>

</div>

<br>

<div class="card-neon">

<h3>Riwayat Transaksi</h3>

<br>

<table class="table">

<tr>

<th>Pembeli</th>
<th>Event</th>
<th>Jumlah</th>
<th>Total</th>
<th>Status</th>

</tr>

@foreach($transaksis as $trx)

<tr>

<td>{{ $trx->nama_pembeli }}</td>

<td>
{{ $trx->tiket->event->nama_event ?? '-' }}
</td>

<td>{{ $trx->jumlah }}</td>

<td>
Rp {{ number_format($trx->total_harga,0,',','.') }}
</td>

<td>{{ $trx->status }}</td>

</tr>

@endforeach

</table>

</div>

@endsection
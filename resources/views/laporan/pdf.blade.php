<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">

<style>

body{
font-family: Arial;
}

table{
width:100%;
border-collapse:collapse;
}

th,td{
border:1px solid black;
padding:8px;
}

</style>

</head>

<body>

<h2>Laporan Penjualan Tiket Konser</h2>

<p>
Total Pendapatan :
Rp {{ number_format($totalPendapatan,0,',','.') }}
</p>

<p>
Total Tiket Terjual :
{{ $totalTiket }}
</p>

<table>

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

<td>{{ $trx->tiket->event->nama_event ?? '-' }}</td>

<td>{{ $trx->jumlah }}</td>

<td>
Rp {{ number_format($trx->total_harga,0,',','.') }}
</td>

<td>{{ $trx->status }}</td>

</tr>

@endforeach

</table>

</body>
</html>
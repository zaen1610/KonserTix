@extends('layouts.app')

@section('title','Riwayat Pembelian')

@section('content')

<div class="container">

    <h2 class="mb-4 fw-bold">
        🧾 Riwayat Pembelian Tiket
    </h2>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    @if(session('error'))

        <div class="alert alert-danger">

            {{ session('error') }}

        </div>

    @endif

    @if($transaksis->count()==0)

        <div class="alert alert-warning">

            Anda belum pernah membeli tiket.

        </div>

    @else

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="table-dark">

                    <tr>

                        <th>No</th>

                        <th>Event</th>

                        <th>Jenis Tiket</th>

                        <th>Harga</th>

                        <th>Jumlah</th>

                        <th>Total</th>

                        <th>Status</th>

                        <th>Tanggal</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($transaksis as $key=>$transaksi)

                    <tr>

                        <td>

                            {{ $transaksis->firstItem()+$key }}

                        </td>

                        <td>

                            {{ $transaksi->tiket->event->nama_event ?? '-' }}

                        </td>

                        <td>

                            {{ $transaksi->tiket->jenis ?? '-' }}

                        </td>

                        <td>

                            Rp {{ number_format($transaksi->tiket->harga ?? 0,0,',','.') }}

                        </td>

                        <td>

                            {{ $transaksi->jumlah }}

                        </td>

                        <td>

                            Rp {{ number_format($transaksi->total_harga,0,',','.') }}

                        </td>

                        <td>

                            @if($transaksi->status=="Pending")

                                <span class="badge bg-warning text-dark">

                                    Pending

                                </span>

                            @elseif($transaksi->status=="Confirmed")

                                <span class="badge bg-success">

                                    Confirmed

                                </span>

                            @elseif($transaksi->status=="Rejected")

                                <span class="badge bg-danger">

                                    Rejected

                                </span>

                            @else

                                <span class="badge bg-secondary">

                                    {{ $transaksi->status }}

                                </span>

                            @endif

                        </td>

                        <td>

                            {{ $transaksi->created_at->format('d M Y H:i') }}

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <div class="mt-3">

            {{ $transaksis->links() }}

        </div>

    @endif

</div>

@endsection
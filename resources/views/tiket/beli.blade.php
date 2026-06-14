@extends('layouts.app')

@section('title','Beli Tiket')

@section('content')

<div class="container">

    <h2 class="mb-4 fw-bold">
        🎟️ Pembelian Tiket
    </h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">

            <div class="mb-3">
                <strong>Event</strong>
                <div>{{ $tiket->event->nama_event ?? '-' }}</div>
            </div>

            <div class="mb-3">
                <strong>Jenis Tiket</strong>
                <div>{{ $tiket->jenis }}</div>
            </div>

            <div class="mb-3">
                <strong>Harga</strong>
                <div>Rp {{ number_format($tiket->harga,0,',','.') }}</div>
            </div>

            <div class="mb-3">
                <strong>Stok Tersedia</strong>
                <div>
                    @if($tiket->stok > 0)
                        <span class="badge bg-success">{{ $tiket->stok }} Tiket</span>
                    @else
                        <span class="badge bg-danger">Habis</span>
                    @endif
                </div>
            </div>

            @if($tiket->stok > 0)

                <form action="{{ route('tiket.beli.process', $tiket->id) }}" method="POST">
                    @csrf

                    <input type="hidden" name="tiket_id" value="{{ $tiket->id }}">

                    <div class="mb-3">
                        <label>Nama Pembeli</label>
                        <input
                            type="text"
                            name="nama_pembeli"
                            class="form-control"
                            value=""
                            placeholder="Nama pembeli">
                    </div>

                    <div class="mb-3">
                        <label>Jumlah</label>
                        <input
                            type="number"
                            name="jumlah"
                            class="form-control"
                            value=""
                            placeholder="0"
                            min="0">
                    </div>

                    <div class="mb-3">
                        <label>Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-control">
                            <option value="Tunai">Tunai</option>
                            <option value="QRIS">QRIS</option>
                            <option value="Transfer">Transfer</option>
                        </select>
                    </div>



                    <button class="btn btn-success w-100">
                        🎫 Konfirmasi Pembelian
                    </button>

                </form>

            @else

                <div class="alert alert-warning mb-0">
                    Tiket habis, silakan pilih event lain.
                </div>

            @endif

        </div>
    </div>

</div>

@endsection


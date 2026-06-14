@extends('layouts.app')
@section('title', 'Tambah Transaksi')
@section('page-title', 'Tambah Transaksi')

@section('content')

<div class="page-header">
    <div>
        <div class="breadcrumb-dark">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <i class="bi bi-chevron-right" style="font-size:0.6rem"></i>
            <a href="{{ route('transaksi.index') }}">Transaksi</a>
            <i class="bi bi-chevron-right" style="font-size:0.6rem"></i>
            <span class="current">Tambah</span>
        </div>

        <div class="page-header-title">
            Tambah Transaksi Baru
        </div>

        <div class="page-header-sub">
            Input pembelian tiket konser
        </div>
    </div>
</div>

<div class="row g-3">

    <div class="col-md-8">

        <div class="card-dark">

            <div class="card-header">
                <div style="font-family:var(--font-head); font-weight:700">
                    Form Transaksi
                </div>
            </div>

            <div class="card-body">

                <form action="{{ route('transaksi.store') }}"
                      method="POST">

                    @csrf

                    @if($errors->any())
                    <div class="alert-error-dark">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                    @endif

                    <div class="form-group mb-3">
                        <label class="form-label">
                            Tiket *
                        </label>

                        <select
                            name="tiket_id"
                            id="tiket_id"
                            class="form-control-dark"
                            required>

                            <option value="">
                                -- Pilih Tiket --
                            </option>

                            @foreach($tikets as $tiket)
                            <option
                                value="{{ $tiket->id }}"
                                data-harga="{{ $tiket->harga }}">

                                {{ $tiket->event->nama_event }}
                                -
                                {{ $tiket->jenis }}
                                -
                                Rp {{ number_format($tiket->harga,0,',','.') }}

                            </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">
                            Nama Pembeli *
                        </label>

                        <input
                            type="text"
                            name="nama_pembeli"
                            class="form-control-dark"
                            required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">
                            Jumlah Tiket *
                        </label>

                        <input
                            type="number"
                            id="jumlah"
                            name="jumlah"
                            class="form-control-dark"
                            min="1"
                            value="1"
                            required>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">
                            Total Harga
                        </label>

                        <input
                            type="number"
                            id="total_harga"
                            name="total_harga"
                            class="form-control-dark"
                            readonly
                            required>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label">
                            Status
                        </label>

                        <select
                            name="status"
                            class="form-control-dark">

                            <option value="Pending">
                                Pending
                            </option>

                            <option value="Berhasil">
                                Berhasil
                            </option>

                            <option value="Batal">
                                Batal
                            </option>

                        </select>
                    </div>

                    <div
                        class="d-flex gap-3 mt-4"
                        style="padding-top:16px;border-top:1px solid var(--border)">

                        <button
                            type="submit"
                            class="btn-primary-glow">

                            <i class="bi bi-check-lg"></i>
                            Simpan Transaksi

                        </button>

                        <a
                            href="{{ route('transaksi.index') }}"
                            class="btn-outline-soft">

                            <i class="bi bi-x-lg"></i>
                            Batal

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card-dark">

            <div class="card-header">
                <div style="font-family:var(--font-head); font-weight:700">
                    Ringkasan
                </div>
            </div>

            <div class="card-body">

                <div style="margin-bottom:15px;">
                    <small style="color:var(--text-muted)">
                        Total Pembayaran
                    </small>

                    <h3
                        id="previewTotal"
                        style="color:var(--accent-gold)">
                        Rp 0
                    </h3>
                </div>

                <hr>

                <small style="color:var(--text-muted)">
                    Pilih tiket dan jumlah pembelian untuk menghitung total otomatis.
                </small>

            </div>

        </div>

    </div>

</div>

@push('scripts')

<script>

function hitungTotal()
{
    let tiket =
        document.getElementById('tiket_id');

    let harga =
        tiket.options[tiket.selectedIndex]
        ?.getAttribute('data-harga') || 0;

    let jumlah =
        document.getElementById('jumlah')
        .value || 0;

    let total =
        parseInt(harga) *
        parseInt(jumlah);

    document.getElementById(
        'total_harga'
    ).value = total;

    document.getElementById(
        'previewTotal'
    ).innerHTML =
        'Rp ' +
        total.toLocaleString('id-ID');
}

document
.getElementById('tiket_id')
.addEventListener(
    'change',
    hitungTotal
);

document
.getElementById('jumlah')
.addEventListener(
    'input',
    hitungTotal
);

</script>

@endpush

@endsection
@extends('layouts.app')

@section('title','Tambah Transaksi')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            <h4>Tambah Transaksi</h4>

        </div>

        <div class="card-body">

            @if($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form action="{{ route('transaksi.store') }}" method="POST">

                @csrf

                <div class="mb-3">

                    <label>Tiket</label>

                    <select
                        name="tiket_id"
                        class="form-control"
                        required>

                        <option value="">Pilih Tiket</option>

                        @foreach($tikets as $tiket)

                            <option value="{{ $tiket->id }}">

                                {{ $tiket->event->nama_event }}
                                -
                                {{ $tiket->jenis }}
                                -
                                Rp {{ number_format($tiket->harga,0,',','.') }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label>Nama Pembeli</label>

                    <input
                        type="text"
                        name="nama_pembeli"
                        class="form-control"
                        value="{{ old('nama_pembeli') }}"
                        required>

                </div>

                <div class="mb-3">

                    <label>Jumlah Tiket</label>

                    <input
                        type="number"
                        name="jumlah"
                        class="form-control"
                        min="1"
                        value="1"
                        required>

                </div>

                <div class="mb-3">

                    <label>Metode Pembayaran</label>

                    <select
                        name="metode_pembayaran"
                        class="form-control">


                        <option value="Pending">

                            Pending

                        </option>

                        <option value="Confirmed">

                            Confirmed

                        </option>

                        <option value="Rejected">

                            Rejected

                        </option>

                    </select>

                </div>

                <button class="btn btn-success">

                    Simpan

                </button>

                <a
                    href="{{ route('transaksi.index') }}"
                    class="btn btn-secondary">

                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>

@endsection
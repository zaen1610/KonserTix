@extends('layouts.app')

@section('title','Edit Transaksi')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-warning">

            <h4>Edit Transaksi</h4>

        </div>

        <div class="card-body">

            @if($errors->any())

                <div class="alert alert-danger">

                    <ul>

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form
                action="{{ route('transaksi.update',$transaksi->id) }}"
                method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label>Tiket</label>

                    <select
                        name="tiket_id"
                        class="form-control">

                        @foreach($tikets as $tiket)

                            <option
                                value="{{ $tiket->id }}"
                                {{ $transaksi->tiket_id==$tiket->id ? 'selected':'' }}>

                                {{ $tiket->event->nama_event }}
                                -
                                {{ $tiket->jenis }}

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
                        value="{{ old('nama_pembeli',$transaksi->nama_pembeli) }}"
                        required>

                </div>

                <div class="mb-3">

                    <label>Jumlah</label>

                    <input
                        type="number"
                        name="jumlah"
                        class="form-control"
                        value="{{ old('jumlah',$transaksi->jumlah) }}"
                        required>

                </div>

                <div class="mb-3">

                    <label>Total Harga</label>

                    <input
                        type="number"
                        name="total_harga"
                        class="form-control"
                        value="{{ old('total_harga',$transaksi->total_harga) }}"
                        required>

                </div>

                <div class="mb-3">

                    <label>Metode Pembayaran</label>

                    <select
                        name="metode_pembayaran"
                        class="form-control">


                        <option
                            value="Pending"
                            {{ $transaksi->metode_pembayaran=="Pending" ? 'selected':'' }}>

                            Pending

                        </option>

                        <option
                            value="Confirmed"
                            {{ $transaksi->metode_pembayaran=="Confirmed" ? 'selected':'' }}>

                            Confirmed

                        </option>

                        <option
                            value="Rejected"
                            {{ $transaksi->metode_pembayaran=="Rejected" ? 'selected':'' }}>

                            Rejected

                        </option>

                    </select>

                </div>

                <div class="mb-3">

                    <label>Status</label>

                    <select
                        name="status"
                        class="form-control">


                        <option
                            value="Pending"
                            {{ $transaksi->status=="Pending" ? 'selected':'' }}>

                            Pending

                        </option>

                        <option
                            value="Confirmed"
                            {{ $transaksi->status=="Confirmed" ? 'selected':'' }}>

                            Confirmed

                        </option>

                        <option
                            value="Rejected"
                            {{ $transaksi->status=="Rejected" ? 'selected':'' }}>

                            Rejected

                        </option>

                    </select>

                </div>

                <button class="btn btn-success">

                    Update

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
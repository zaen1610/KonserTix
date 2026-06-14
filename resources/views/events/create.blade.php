@extends('layouts.app')

@section('title','Tambah Event')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            <h4>Tambah Event</h4>

        </div>

        <div class="card-body">

            @if ($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form
                action="{{ route('events.store') }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf

                <div class="mb-3">

                    <label>Nama Event</label>

                    <input
                        type="text"
                        name="nama_event"
                        class="form-control"
                        value="{{ old('nama_event') }}"
                        required>

                </div>

                <div class="mb-3">

                    <label>Kategori</label>

                    <select
                        name="kategori_event_id"
                        class="form-control"
                        required>

                        <option value="">Pilih Kategori</option>

                        @foreach($kategori as $k)

                            <option
                                value="{{ $k->id }}">

                                {{ $k->nama }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label>Lokasi</label>

                    <select
                        name="lokasi_id"
                        class="form-control"
                        required>

                        <option value="">Pilih Lokasi</option>

                        @foreach($lokasi as $l)

                            <option
                                value="{{ $l->id }}">

                                {{ $l->nama }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label>Tanggal Event</label>

                    <input
                        type="date"
                        name="tanggal"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label>Deskripsi</label>

                    <textarea
                        name="deskripsi"
                        rows="5"
                        class="form-control"
                        required></textarea>

                </div>

                <div class="mb-3">

                    <label>Gambar Event</label>

                    <input
                        type="file"
                        name="gambar"
                        class="form-control">

                </div>

                <button
                    class="btn btn-success">

                    Simpan

                </button>

                <a
                    href="{{ route('events.index') }}"
                    class="btn btn-secondary">

                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>

@endsection
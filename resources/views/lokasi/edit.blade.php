@extends('layouts.app')

@section('content')

<div class="hero">

    <h1>✏️ Edit Lokasi</h1>

    <p>Ubah data lokasi untuk digunakan oleh event konser.</p>

</div>

<div class="card-neon">

    <div class="card-header bg-transparent border-0">
        <h3 class="m-0">Form Edit Lokasi</h3>
    </div>

    <div class="card-body">

        <form action="{{ route('lokasi.update', $lokasi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Nama Lokasi</label>
                <input
                    type="text"
                    name="nama_lokasi"
                    class="form-control form-control-dark"
                    value="{{ old('nama_lokasi', $lokasi->nama_lokasi) }}"
                    required
                >
                @error('nama_lokasi')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Alamat</label>
                <textarea
                    name="alamat"
                    class="form-control form-control-dark"
                    rows="4"
                    required
                >{{ old('alamat', $lokasi->alamat) }}</textarea>
                @error('alamat')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Kapasitas</label>
                <input
                    type="number"
                    name="kapasitas"
                    class="form-control form-control-dark"
                    value="{{ old('kapasitas', $lokasi->kapasitas) }}"
                    required
                >
                @error('kapasitas')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary-glow">
                    <i class="bi bi-check-circle-fill"></i>
                    Simpan
                </button>

                <a href="{{ route('lokasi.index') }}" class="btn btn-outline-soft">
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>
            </div>

        </form>

    </div>

</div>

@endsection


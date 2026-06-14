@extends('layouts.app')
@section('title', 'Edit Event')
@section('page-title', 'Edit Event')

@section('content')
<div class="page-header">
    <div>
        <div class="breadcrumb-dark">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <i class="bi bi-chevron-right" style="font-size:0.6rem"></i>
            <a href="{{ route('events.index') }}">Events</a>
            <i class="bi bi-chevron-right" style="font-size:0.6rem"></i>
            <span class="current">Edit</span>
        </div>
        <div class="page-header-title">Edit Event</div>
        <div class="page-header-sub">Perbarui informasi event: <strong>{{ $event->nama_event }}</strong></div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('events.show', $event->id) }}" class="btn-outline-soft">
            <i class="bi bi-eye-fill"></i> Lihat Detail
        </a>
        <form action="{{ route('events.destroy', $event->id) }}" method="POST"
            onsubmit="return confirm('Yakin hapus event ini? Semua tiket terkait akan terhapus.')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-danger-soft" style="padding:9px 16px">
                <i class="bi bi-trash-fill"></i> Hapus
            </button>
        </form>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-8">
        <div class="card-dark">
            <div class="card-header">
                <div style="font-family:var(--font-head); font-weight:700">Edit Informasi Event</div>
            </div>
            <div class="card-body">
                <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @if($errors->any())
                    <div class="alert-error-dark">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
                    </div>
                    @endif

                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Nama Event *</label>
                                <input type="text" name="nama_event" class="form-control-dark"
                                    value="{{ old('nama_event', $event->nama_event) }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Kategori *</label>
                                <select name="kategori_id" class="form-control-dark" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategoris ?? [] as $k)
                                    <option value="{{ $k->id }}"
                                        {{ old('kategori_id', $event->kategori_id) == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kategori }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Lokasi *</label>
                                <select name="lokasi_id" class="form-control-dark" required>
                                    <option value="">-- Pilih Lokasi --</option>
                                    @foreach($lokasis ?? [] as $l)
                                    <option value="{{ $l->id }}"
                                        {{ old('lokasi_id', $event->lokasi_id) == $l->id ? 'selected' : '' }}>
                                        {{ $l->nama_lokasi }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Tanggal Event *</label>
                                <input type="date" name="tanggal" class="form-control-dark"
                                    value="{{ old('tanggal', $event->tanggal) }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Jam Mulai</label>
                                <input type="time" name="jam" class="form-control-dark"
                                    value="{{ old('jam', $event->jam) }}">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Deskripsi Event</label>
                                <textarea name="deskripsi" class="form-control-dark" rows="4">{{ old('deskripsi', $event->deskripsi) }}</textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Poster Event (kosongkan jika tidak diganti)</label>
                                @if($event->poster)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$event->poster) }}"
                                        style="max-width:120px; border-radius:8px; border:1px solid var(--border)">
                                    <div style="font-size:0.72rem; color:var(--text-muted); margin-top:4px">Poster saat ini</div>
                                </div>
                                @endif
                                <input type="file" name="poster" class="form-control-dark" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-4" style="padding-top:16px; border-top:1px solid var(--border)">
                        <button type="submit" class="btn-primary-glow">
                            <i class="bi bi-check-lg"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('events.index') }}" class="btn-outline-soft">
                            <i class="bi bi-x-lg"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Tiket terkait --}}
    <div class="col-md-4">
        <div class="card-dark">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div style="font-family:var(--font-head); font-weight:700; font-size:0.9rem">Tiket Event Ini</div>
                <a href="{{ route('tiket.create') }}?event_id={{ $event->id }}" class="btn-primary-glow" style="padding:6px 12px; font-size:0.75rem">
                    <i class="bi bi-plus"></i> Tiket
                </a>
            </div>
            <div class="card-body" style="padding:0">
                @forelse($event->tikets ?? [] as $tiket)
                <div style="padding:14px 18px; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center">
                    <div>
                        <div style="font-weight:600; font-size:0.875rem">{{ $tiket->jenis }}</div>
                        <div style="font-size:0.72rem; color:var(--text-muted)">Stok: {{ $tiket->stok }}</div>
                    </div>
                    <div style="text-align:right">
                        <div style="font-weight:700; font-size:0.9rem; color:var(--accent-gold)">
                            Rp{{ number_format($tiket->harga) }}
                        </div>
                        <a href="{{ route('tiket.edit', $tiket->id) }}" style="font-size:0.7rem; color:var(--accent-2)">Edit</a>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="bi bi-ticket-perforated"></i>
                    <p>Belum ada tiket untuk event ini</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', $event->nama_event)

@section('content')

<div class="mb-4">
    <a href="{{ route('user.events') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Event
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success rounded-3 mb-4">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger rounded-3 mb-4">
        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
    </div>
@endif

{{-- Detail Event --}}
<div class="card-neon mb-4">
    <h2 class="fw-bold mb-1">🎵 {{ $event->nama_event }}</h2>
    <p class="text-muted small mb-3">
        <i class="bi bi-tag-fill me-1"></i>{{ $event->kategori->nama_kategori ?? '-' }}
    </p>

    <div class="row g-3 mb-3">
        <div class="col-sm-6">
            <div style="background:rgba(168,85,247,0.1);border-radius:12px;padding:14px">
                <div class="text-muted small mb-1"><i class="bi bi-calendar3 me-1"></i>Tanggal</div>
                <div class="fw-bold">{{ \Carbon\Carbon::parse($event->tanggal)->isoFormat('D MMMM Y') }}</div>
            </div>
        </div>
        <div class="col-sm-6">
            <div style="background:rgba(168,85,247,0.1);border-radius:12px;padding:14px">
                <div class="text-muted small mb-1"><i class="bi bi-clock me-1"></i>Jam</div>
                <div class="fw-bold">{{ $event->jam ? $event->jam . ' WIB' : '-' }}</div>
            </div>
        </div>
        <div class="col-sm-12">
            <div style="background:rgba(168,85,247,0.1);border-radius:12px;padding:14px">
                <div class="text-muted small mb-1"><i class="bi bi-geo-alt-fill me-1"></i>Lokasi</div>
                <div class="fw-bold">{{ $event->lokasi->nama_lokasi ?? '-' }}</div>
                <div class="text-muted small">{{ $event->lokasi->alamat ?? '' }}</div>
            </div>
        </div>
    </div>

    <div class="text-muted" style="line-height:1.7">
        {!! nl2br(e($event->deskripsi)) !!}
    </div>
</div>

{{-- Pilihan Tiket --}}
<h4 class="fw-bold mb-3">🎫 Pilih Tiket</h4>

@if($event->tikets->isEmpty())
    <div class="card-neon text-center py-4 text-muted">
        <i class="bi bi-ticket-perforated fs-3 d-block mb-2"></i>
        Belum ada tiket tersedia untuk event ini.
    </div>
@else
    <div class="row g-3">
        @foreach($event->tikets as $tiket)
        <div class="col-md-4">
            <div class="card-neon h-100">
                <div class="fw-bold mb-1">{{ $tiket->jenis ?? 'Tiket' }}</div>
                <div class="mb-2" style="color:var(--accent-1);font-size:1.2rem;font-weight:700">
                    Rp {{ number_format($tiket->harga, 0, ',', '.') }}
                </div>
                <div class="text-muted small mb-3">
                    Stok: {{ $tiket->stok > 0 ? $tiket->stok . ' tersisa' : '🚫 Habis' }}
                </div>

                @if($tiket->stok > 0)
                    <form action="{{ route('tiket.beli', $tiket->id) }}" method="POST">
                        @csrf
                        @php
                            $jenis = $tiket->jenis ?? 'Tiket';
                            $hargaFormatted = number_format($tiket->harga, 0, ',', '.');
                        @endphp
                        <button type="submit" class="btn btn-neon w-100"
                                onclick="return confirm('Beli 1 tiket {{ addslashes($jenis) }} seharga Rp {{ $hargaFormatted }}?')">
                            <i class="bi bi-cart-plus me-1"></i> Beli Sekarang
                        </button>
                    </form>
                @else
                    <button class="btn w-100" disabled
                            style="background:rgba(255,255,255,0.05);color:#666;border-radius:10px">
                        Stok Habis
                    </button>
                @endif
            </div>
        </div>
        @endforeach
    </div>
@endif

@endsection


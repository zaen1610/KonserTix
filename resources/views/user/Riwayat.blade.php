@extends('layouts.app')

@section('title', 'Riwayat Pembelian')

@section('content')

<div class="page-header mb-4">
    <h2 class="fw-bold">🧾 Riwayat Pembelian</h2>
    <p class="text-muted small">Daftar tiket yang pernah Anda beli</p>
</div>

@if(session('success'))
    <div class="alert alert-success rounded-3 mb-4">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif

@if($transaksis->count() === 0)
    <div class="card-neon text-center py-5">
        <div style="font-size:3rem;">🎫</div>
        <h5 class="mt-3">Belum ada pembelian</h5>
        <p class="text-muted small">Anda belum pernah membeli tiket.</p>
        <a href="{{ route('user.events') }}" class="btn btn-neon mt-2">
            <i class="bi bi-search me-1"></i> Jelajahi Event
        </a>
    </div>
@else
    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle rounded-3 overflow-hidden">
            <thead>
                <tr style="background: rgba(168,85,247,0.2);">
                    <th>#</th>
                    <th>Event</th>
                    <th>Tiket</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Tanggal Beli</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksis as $i => $t)
                <tr>
                    <td>{{ $transaksis->firstItem() + $i }}</td>
                    <td>
                        <strong>{{ $t->tiket->event->nama_event ?? '-' }}</strong><br>
                        <small class="text-muted">{{ $t->tiket->event->tanggal ?? '' }}</small>
                    </td>
                    <td>{{ $t->tiket->nama_tiket ?? '-' }}</td>
                    <td>{{ $t->jumlah }}</td>
                    <td>Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                    <td>{{ $t->created_at->format('d M Y, H:i') }}</td>
                    <td>
                        @if($t->status === 'Pending')
                            <span class="badge rounded-pill"
                                  style="background:#f59e0b; color:#000; padding:6px 12px;">
                                ⏳ Pending
                            </span>
                        @elseif($t->status === 'Confirmed')
                            <span class="badge rounded-pill"
                                  style="background:#22c55e; color:#000; padding:6px 12px;">
                                ✅ Dikonfirmasi
                            </span>
                        @elseif($t->status === 'Rejected')
                            <span class="badge rounded-pill"
                                  style="background:#ef4444; padding:6px 12px;">
                                ❌ Ditolak
                            </span>
                        @else
                            <span class="badge bg-secondary rounded-pill" style="padding:6px 12px;">
                                {{ $t->status }}
                            </span>
                        @endif
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

@endsection
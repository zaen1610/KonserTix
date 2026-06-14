@extends('layouts.app')

@section('title', 'Data Transaksi')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0">🛒 Data Transaksi</h2>
        <p class="text-muted small mb-0">Kelola semua transaksi pembelian tiket</p>
    </div>
    <a href="{{ route('transaksi.create') }}" class="btn btn-neon">
        <i class="bi bi-plus-circle me-1"></i> Tambah Transaksi
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success rounded-3 mb-3">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif

<div class="card-neon p-0" style="overflow:hidden;">
<table class="table table-dark table-hover mb-0 align-middle">
<thead>
<tr style="background:rgba(168,85,247,0.2);">
    <th class="px-3 py-3">Invoice</th>
    <th>Pembeli</th>
    <th>Event</th>
    <th>Jenis Tiket</th>
    <th>Jumlah</th>
    <th>Total</th>
    <th>Status</th>
    <th class="text-center">Aksi</th>
</tr>
</thead>
<tbody>

@forelse($transaksis as $transaksi)
<tr>
    <td class="px-3">
        <span class="fw-bold" style="color:var(--accent-1)">
            INV{{ str_pad($transaksi->id, 4, '0', STR_PAD_LEFT) }}
        </span>
    </td>

    <td>
        <div>{{ $transaksi->nama_pembeli }}</div>
        @if($transaksi->user)
            <small class="text-muted">{{ $transaksi->user->email }}</small>
        @endif
    </td>

    <td>{{ $transaksi->tiket->event->nama_event ?? '-' }}</td>
    <td>{{ $transaksi->tiket->jenis ?? '-' }}</td>
    <td>{{ $transaksi->jumlah }}</td>
    <td>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>

    {{-- ====== BADGE STATUS ====== --}}
    <td>
        @if($transaksi->status === 'Confirmed')
            <span class="badge rounded-pill"
                  style="background:#22c55e;color:#000;padding:6px 12px">
                ✅ Dikonfirmasi
            </span>
        @elseif($transaksi->status === 'Pending')
            <span class="badge rounded-pill"
                  style="background:#f59e0b;color:#000;padding:6px 12px">
                ⏳ Pending
            </span>
        @elseif($transaksi->status === 'Rejected')
            <span class="badge rounded-pill"
                  style="background:#ef4444;padding:6px 12px">
                ❌ Ditolak
            </span>
        @else
            <span class="badge bg-secondary rounded-pill" style="padding:6px 12px">
                {{ $transaksi->status }}
            </span>
        @endif
    </td>

    {{-- ====== AKSI ====== --}}
    <td class="text-center">
        <div class="d-flex gap-1 justify-content-center flex-wrap">

            <a href="{{ route('transaksi.show', $transaksi->id) }}"
               class="btn btn-sm btn-outline-info">
                <i class="bi bi-eye"></i>
            </a>

            <a href="{{ route('transaksi.edit', $transaksi->id) }}"
               class="btn btn-sm btn-outline-warning">
                <i class="bi bi-pencil"></i>
            </a>

            {{-- ★ TOMBOL KONFIRMASI — hanya tampil jika status Pending --}}
            @if($transaksi->status === 'Pending')
                {{-- Konfirmasi (approve) --}}
                <form action="{{ route('transaksi.konfirmasi', $transaksi->id) }}"
                      method="POST" style="display:inline">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="Confirmed">
                    <button type="submit" class="btn btn-sm btn-success"
                            title="Konfirmasi"
                            onclick="return confirm('Konfirmasi transaksi ini?')">
                        <i class="bi bi-check-lg"></i>
                    </button>
                </form>

                {{-- Tolak (reject) --}}
                <form action="{{ route('transaksi.konfirmasi', $transaksi->id) }}"
                      method="POST" style="display:inline">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="Rejected">
                    <button type="submit" class="btn btn-sm btn-danger"
                            title="Tolak"
                            onclick="return confirm('Tolak transaksi ini?')">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </form>
            @endif

            {{-- Hapus --}}
            <form action="{{ route('transaksi.destroy', $transaksi->id) }}"
                  method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger"
                        title="Hapus"
                        onclick="return confirm('Hapus transaksi INV{{ str_pad($transaksi->id,4,\"0\",STR_PAD_LEFT) }}?')">
                    <i class="bi bi-trash"></i>
                </button>
            </form>

        </div>
    </td>

</tr>
@empty
<tr>
    <td colspan="8" class="text-center py-4 text-muted">
        <i class="bi bi-inbox fs-4 d-block mb-2"></i>
        Belum ada transaksi
    </td>
</tr>
@endforelse

</tbody>
</table>
</div>

<div class="mt-3">{{ $transaksis->links() }}</div>

@endsection
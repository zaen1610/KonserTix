@extends('layouts.app')

@section('title','Detail Transaksi')

@section('content')

<div class="container">

    <div class="mb-4">
        <a href="{{ route('transaksi.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Transaksi
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

    <div class="card-neon mb-4">

        <h2 class="fw-bold mb-3">🧾 Detail Transaksi</h2>

        <div class="row g-3">
            <div class="col-md-6">
                <div style="background:rgba(168,85,247,0.1);border-radius:12px;padding:14px">
                    <div class="text-muted small mb-1">Nama Pembeli</div>
                    <div class="fw-bold">{{ $transaksi->nama_pembeli }}</div>
                </div>
            </div>

            <div class="col-md-6">
                <div style="background:rgba(168,85,247,0.1);border-radius:12px;padding:14px">
                    <div class="text-muted small mb-1">Status</div>
                    <div>
                        @if($transaksi->status=="Pending")
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($transaksi->status=="Confirmed")
                            <span class="badge bg-success">Confirmed</span>
                        @elseif($transaksi->status=="Rejected")
                            <span class="badge bg-danger">Rejected</span>
                        @else
                            <span class="badge bg-secondary">{{ $transaksi->status }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div style="background:rgba(168,85,247,0.1);border-radius:12px;padding:14px">
                    <div class="text-muted small mb-1">Event</div>
                    <div class="fw-bold">{{ $transaksi->tiket->event->nama_event ?? '-' }}</div>
                </div>
            </div>

            <div class="col-md-6">
                <div style="background:rgba(168,85,247,0.1);border-radius:12px;padding:14px">
                    <div class="text-muted small mb-1">Jenis Tiket</div>
                    <div class="fw-bold">{{ $transaksi->tiket->jenis ?? '-' }}</div>
                </div>
            </div>

            <div class="col-md-6">
                <div style="background:rgba(168,85,247,0.1);border-radius:12px;padding:14px">
                    <div class="text-muted small mb-1">Jumlah</div>
                    <div class="fw-bold">{{ $transaksi->jumlah }}</div>
                </div>
            </div>

            <div class="col-md-6">
                <div style="background:rgba(168,85,247,0.1);border-radius:12px;padding:14px">
                    <div class="text-muted small mb-1">Total Harga</div>
                    <div class="fw-bold">Rp {{ number_format($transaksi->total_harga,0,',','.') }}</div>
                </div>
            </div>

            <div class="col-12">
                <div style="background:rgba(168,85,247,0.1);border-radius:12px;padding:14px">
                    <div class="text-muted small mb-1">Tanggal Transaksi</div>
                    <div class="fw-bold">
                        {{ optional($transaksi->created_at)->format('d M Y H:i') }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('transaksi.edit',$transaksi->id) }}" class="btn btn-warning">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>

        <form action="{{ route('transaksi.destroy',$transaksi->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash me-1"></i> Hapus
            </button>
        </form>
    </div>

</div>

@endsection


@extends('layouts.app')
@section('title', 'Manajemen Tiket')
@section('page-title', 'Tiket')

@section('content')
<div class="page-header">
    <div>
        <div class="breadcrumb-dark">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <i class="bi bi-chevron-right" style="font-size:0.6rem"></i>
            <span class="current">Tiket</span>
        </div>
        <div class="page-header-title">Manajemen Tiket 🎫</div>
        <div class="page-header-sub">Kelola semua jenis tiket untuk setiap event</div>
    </div>
    <a href="{{ route('tiket.create') }}" class="btn-primary-glow">
        <i class="bi bi-plus-lg"></i> Tambah Tiket
    </a>
</div>

{{-- Summary cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card purple">
            <div class="stat-icon"><i class="bi bi-ticket-perforated-fill"></i></div>
            <div class="stat-value">{{ $tikets->count() }}</div>
            <div class="stat-label">Total Jenis Tiket</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card indigo">
            <div class="stat-icon"><i class="bi bi-stack"></i></div>
            <div class="stat-value">{{ $tikets->sum('stok') }}</div>
            <div class="stat-label">Total Stok</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card gold">
            <div class="stat-icon"><i class="bi bi-currency-dollar"></i></div>
            <div class="stat-value">Rp{{ number_format($tikets->min('harga') ?? 0) }}</div>
            <div class="stat-label">Harga Terendah</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card green">
            <div class="stat-icon"><i class="bi bi-trophy-fill"></i></div>
            <div class="stat-value">Rp{{ number_format($tikets->max('harga') ?? 0) }}</div>
            <div class="stat-label">Harga Tertinggi</div>
        </div>
    </div>
</div>

<div class="card-dark">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div style="font-family:var(--font-head); font-weight:700">Semua Tiket</div>
        <div class="d-flex gap-2">
            <div style="position:relative">
                <i class="bi bi-search" style="position:absolute; left:10px; top:50%; transform:translateY(-50%); color:var(--text-muted); font-size:0.8rem"></i>
                <input type="text" class="form-control-dark" placeholder="Cari tiket..."
                    style="padding-left:32px; width:200px" onkeyup="filterTiket(this)">
            </div>
        </div>
    </div>

    <div class="card-body" style="padding:0">
        <table class="table table-dark-custom mb-0" id="tiketTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Event</th>
                    <th>Jenis Tiket</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($tikets as $i => $tiket)
                <tr>
                    <td style="color:var(--text-muted)">{{ $i + 1 }}</td>

                    <td>
                        <div style="font-weight:600; font-size:0.875rem">
                            {{ $tiket->event->nama_event ?? '—' }}
                        </div>
                        @if($tiket->event && $tiket->event->tanggal)
                        <div style="font-size:0.72rem; color:var(--text-muted)">
                            {{ \Carbon\Carbon::parse($tiket->event->tanggal)->format('d M Y') }}
                        </div>
                        @endif
                    </td>

                    <td>
                        @php
                            $jenisColor = match(strtolower($tiket->jenis)) {
                                'vvip'     => 'badge-gold',
                                'vip'      => 'badge-purple',
                                'festival' => 'badge-indigo',
                                default    => 'badge-green',
                            };
                        @endphp
                        <span class="{{ $jenisColor }}">{{ strtoupper($tiket->jenis) }}</span>
                    </td>

                    <td style="font-weight:700; color:var(--accent-gold)">
                        Rp{{ number_format($tiket->harga) }}
                    </td>

                    <td style="font-weight:600">{{ $tiket->stok }}</td>

                    <td>
                        @if($tiket->stok > 50)
                            <span class="badge-green">Tersedia</span>
                        @elseif($tiket->stok > 10)
                            <span class="badge-gold">Terbatas</span>
                        @elseif($tiket->stok > 0)
                            <span class="badge-red">Hampir Habis</span>
                        @else
                            <span class="badge-red">Habis</span>
                        @endif
                    </td>

                    <td>
                        <div class="d-flex gap-2">

                            {{-- DETAIL / EDIT --}}
                            <a href="{{ route('tiket.edit', $tiket->id) }}" class="btn-edit-soft">
                                <i class="bi bi-pencil-fill"></i> Edit
                            </a>

                            {{-- ✅ TAMBAHAN: BUTTON BELI --}}
                            @if($tiket->stok > 0)
                          <a href="{{ route('transaksi.create', ['tiket_id' => $tiket->id]) }}" class="btn-primary-glow">
    <i class="bi bi-cart-fill"></i> Beli
</a>
                            @else
                                <button class="btn-danger-soft" disabled>
                                    Habis
                                </button>
                            @endif

                            {{-- DELETE (TETAP ASLI) --}}
                            <form action="{{ route('tiket.destroy', $tiket->id) }}" method="POST"
                                onsubmit="return confirm('Hapus tiket ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger-soft">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="bi bi-ticket-perforated"></i>
                            <p>Belum ada tiket. <a href="{{ route('tiket.create') }}">Tambah tiket</a></p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
function filterTiket(input) {
    const val = input.value.toLowerCase();
    document.querySelectorAll('#tiketTable tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(val) ? '' : 'none';
    });
}
</script>
@endpush

@endsection
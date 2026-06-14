@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
/* Hero Banner */
.hero-banner {
    background: linear-gradient(135deg, #1a0533 0%, #0d1547 60%, #0a0a0f 100%);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 36px 40px;
    position: relative;
    overflow: hidden;
    margin-bottom: 28px;
}
.hero-banner::before {
    content: '';
    position: absolute;
    top: -80px; right: -80px;
    width: 320px; height: 320px;
    background: radial-gradient(circle, rgba(168,85,247,0.3) 0%, transparent 70%);
    pointer-events: none;
}
.hero-banner::after {
    content: '';
    position: absolute;
    bottom: -60px; left: 40%;
    width: 200px; height: 200px;
    background: radial-gradient(circle, rgba(99,102,241,0.2) 0%, transparent 70%);
    pointer-events: none;
}
.hero-title {
    font-family: var(--font-head);
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 8px;
    position: relative;
}
.hero-title .highlight {
    background: linear-gradient(90deg, var(--accent-1), var(--accent-gold));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.hero-sub { color: rgba(255,255,255,0.6); font-size: 0.9rem; position: relative; }
.hero-dots {
    display: flex; gap: 8px; margin-top: 20px; position: relative;
}
.hero-dot {
    width: 8px; height: 8px; border-radius: 50%;
    animation: pulse 2s ease-in-out infinite;
}
.hero-dot:nth-child(1) { background: var(--accent-1); animation-delay: 0s; }
.hero-dot:nth-child(2) { background: var(--accent-2); animation-delay: 0.3s; }
.hero-dot:nth-child(3) { background: var(--accent-gold); animation-delay: 0.6s; }
@keyframes pulse { 0%,100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.4; transform: scale(0.8); } }

/* Quick actions */
.quick-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 28px;
}
.quick-action-btn {
    display: flex; align-items: center; gap: 8px;
    padding: 10px 18px;
    border-radius: 10px;
    font-size: 0.82rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s;
    border: 1px solid var(--border);
    color: var(--text-primary);
    background: var(--bg-card);
}
.quick-action-btn:hover { transform: translateY(-2px); color: white; }
.quick-action-btn.qp { border-color: rgba(168,85,247,0.4); }
.quick-action-btn.qp:hover { background: rgba(168,85,247,0.12); border-color: var(--accent-1); }
.quick-action-btn.qi { border-color: rgba(99,102,241,0.4); }
.quick-action-btn.qi:hover { background: rgba(99,102,241,0.12); border-color: var(--accent-2); }
.quick-action-btn.qg { border-color: rgba(34,197,94,0.4); }
.quick-action-btn.qg:hover { background: rgba(34,197,94,0.12); border-color: #22c55e; }
.quick-action-btn.qa { border-color: rgba(245,158,11,0.4); }
.quick-action-btn.qa:hover { background: rgba(245,158,11,0.12); border-color: var(--accent-gold); }

/* Recent events */
.event-row {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 0;
    border-bottom: 1px solid rgba(255,255,255,0.04);
}
.event-row:last-child { border-bottom: none; padding-bottom: 0; }
.event-thumb {
    width: 50px; height: 50px;
    border-radius: 10px;
    background: linear-gradient(135deg, var(--accent-1), var(--accent-2));
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem; flex-shrink: 0;
}
.event-info { flex: 1; min-width: 0; }
.event-info .event-name {
    font-weight: 600; font-size: 0.875rem;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.event-info .event-meta { font-size: 0.75rem; color: var(--text-muted); margin-top: 2px; }
.event-tiket { text-align: right; }
.event-tiket .sold { font-weight: 700; font-size: 1rem; }
.event-tiket .label { font-size: 0.7rem; color: var(--text-muted); }

/* Chart bar simple */
.chart-bar-wrap { display: flex; align-items: flex-end; gap: 6px; height: 80px; margin-top: 10px; }
.chart-bar-col { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 4px; }
.chart-bar {
    width: 100%;
    border-radius: 4px 4px 0 0;
    background: linear-gradient(180deg, var(--accent-1), var(--accent-2));
    transition: height 0.5s ease;
}
.chart-bar-label { font-size: 0.6rem; color: var(--text-muted); }

/* Trend line */
.trend-up { color: #22c55e; font-size: 0.75rem; }
.trend-down { color: #ef4444; font-size: 0.75rem; }

/* Tabs */
.tab-pills { display: flex; gap: 4px; margin-bottom: 16px; }
.tab-pill {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.78rem;
    cursor: pointer;
    color: var(--text-muted);
    background: transparent;
    border: none;
    transition: all 0.2s;
    font-family: var(--font-body);
}
.tab-pill.active { background: rgba(168,85,247,0.15); color: var(--accent-1); }
.tab-pill:hover:not(.active) { color: var(--text-primary); }
</style>
@endpush

@section('content')

{{-- Hero Banner --}}
<div class="hero-banner">
    <div class="hero-title">
        Selamat datang, <span class="highlight">{{ Auth::user()->name ?? 'Admin' }}!</span>
    </div>
    <p class="hero-sub">Pantau dan kelola seluruh sistem pemesanan tiket konser Anda dari satu tempat.</p>
    <div class="hero-dots">
        <div class="hero-dot"></div>
        <div class="hero-dot"></div>
        <div class="hero-dot"></div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="quick-actions">
    <a href="{{ route('events.create') }}" class="quick-action-btn qp">
        <i class="bi bi-plus-circle-fill"></i> Tambah Event
    </a>
    <a href="{{ route('tiket.create') }}" class="quick-action-btn qi">
        <i class="bi bi-ticket-perforated-fill"></i> Buat Tiket
    </a>
    <a href="{{ route('transaksi.create') }}" class="quick-action-btn qg">
        <i class="bi bi-cart-plus-fill"></i> Transaksi Baru
    </a>
    <a href="{{ route('laporan.index') }}" class="quick-action-btn qa">
        <i class="bi bi-bar-chart-line-fill"></i> Lihat Laporan
    </a>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card purple">
            <div class="stat-icon"><i class="bi bi-music-note-beamed"></i></div>
            <div class="stat-value">{{ $totalEvents ?? 0 }}</div>
            <div class="stat-label">Total Events</div>
            <div class="trend-up mt-2"><i class="bi bi-arrow-up-right"></i> +3 bulan ini</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card indigo">
            <div class="stat-icon"><i class="bi bi-ticket-perforated-fill"></i></div>
            <div class="stat-value">{{ $totalTiketTerjual ?? 0 }}</div>
            <div class="stat-label">Tiket Terjual</div>
            <div class="trend-up mt-2"><i class="bi bi-arrow-up-right"></i> +12% bulan ini</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card gold">
            <div class="stat-icon"><i class="bi bi-cash-stack"></i></div>
            <div class="stat-value">{{ $totalPendapatan ? 'Rp'.number_format($totalPendapatan/1000000,0).'JT' : 'Rp0' }}</div>
            <div class="stat-label">Total Pendapatan</div>
            <div class="trend-up mt-2"><i class="bi bi-arrow-up-right"></i> +8% vs bulan lalu</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card green">
            <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
            <div class="stat-value">{{ $totalUsers ?? 0 }}</div>
            <div class="stat-label">Total Pengguna</div>
            <div class="trend-up mt-2"><i class="bi bi-arrow-up-right"></i> +5 minggu ini</div>
        </div>
    </div>
</div>

{{-- Charts & Recent --}}
<div class="row g-3 mb-4">
    {{-- Weekly Bar Chart --}}
    <div class="col-md-5">
        <div class="card-dark h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <div style="font-family:var(--font-head); font-weight:700; font-size:0.95rem">Penjualan Mingguan</div>
                    <div style="font-size:0.72rem; color:var(--text-muted); margin-top:2px">Tiket terjual 7 hari terakhir</div>
                </div>
                <span class="badge-purple">Minggu Ini</span>
            </div>
            <div class="card-body">
                <div class="chart-bar-wrap" id="weeklyChart">
                    @php
                        $days = ['Sen','Sel','Rab','Kam','Jum','Sab','Min'];
                        $vals = [45, 62, 38, 80, 55, 90, 70];
                        $max  = max($vals);
                    @endphp
                    @foreach($days as $i => $d)
                    <div class="chart-bar-col">
                        <div class="chart-bar"
                            style="height: {{ round($vals[$i]/$max*100).'%' }}; opacity: {{ $i == 5 ? '1' : '0.55' }}"></div>
                        <div class="chart-bar-label">{{ $d }}</div>
                    </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-between mt-3" style="font-size:0.78rem; color:var(--text-muted)">
                    <span>Tertinggi: <strong style="color:var(--accent-1)">90 tiket (Sab)</strong></span>
                    <span>Total: <strong style="color:white">440 tiket</strong></span>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Transactions --}}
    <div class="col-md-7">
        <div class="card-dark h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <div style="font-family:var(--font-head); font-weight:700; font-size:0.95rem">Transaksi Terbaru</div>
                    <div style="font-size:0.72rem; color:var(--text-muted); margin-top:2px">Pembelian tiket terkini</div>
                </div>
                <a href="{{ route('transaksi.index') }}" class="btn-outline-soft" style="font-size:0.75rem; padding:5px 12px">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="card-body" style="padding:0">
                <table class="table table-dark-custom mb-0">
                    <thead>
                        <tr>
                            <th>Pembeli</th>
                            <th>Event</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTransaksi ?? [] as $t)
                        <tr>
                            <td>{{ $t->nama_pembeli }}</td>
                            <td>{{ $t->tiket->event->nama_event ?? '-' }}</td>
                            <td>{{ $t->jumlah }} tiket</td>
                            <td>Rp{{ number_format($t->total_harga) }}</td>
                            <td><span class="badge-green">{{ $t->status }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state py-3">
                                    <i class="bi bi-receipt" style="font-size:1.5rem"></i>
                                    <p>Belum ada transaksi</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Recent Events --}}
<div class="row g-3">
    <div class="col-md-6">
        <div class="card-dark">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div style="font-family:var(--font-head); font-weight:700; font-size:0.95rem">Event Mendatang</div>
                <a href="{{ route('events.index') }}" class="btn-outline-soft" style="font-size:0.75rem; padding:5px 12px">
                    Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="card-body">
                @forelse($upcomingEvents ?? [] as $event)
                <div class="event-row">
                    <div class="event-thumb">🎤</div>
                    <div class="event-info">
                        <div class="event-name">{{ $event->nama_event }}</div>
                        <div class="event-meta">
                            <i class="bi bi-geo-alt-fill" style="color:var(--accent-1)"></i>
                            {{ $event->lokasi->nama_lokasi ?? '-' }} •
                            {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}
                        </div>
                    </div>
                    <div class="event-tiket">
                        <div class="sold">{{ $event->tikets->sum('stok') ?? 0 }}</div>
                        <div class="label">stok</div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="bi bi-calendar-event"></i>
                    <p>Belum ada event terjadwal</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Category Distribution --}}
    <div class="col-md-6">
        <div class="card-dark">
            <div class="card-header">
                <div style="font-family:var(--font-head); font-weight:700; font-size:0.95rem">Distribusi Kategori Event</div>
                <div style="font-size:0.72rem; color:var(--text-muted); margin-top:2px">Breakdown per kategori</div>
            </div>
            <div class="card-body">
                @php
                    $categories = [
                        ['name'=>'Pop/Rock','pct'=>40,'col'=>'var(--accent-1)'],
                        ['name'=>'Jazz','pct'=>25,'col'=>'var(--accent-2)'],
                        ['name'=>'EDM','pct'=>20,'col'=>'var(--accent-gold)'],
                        ['name'=>'Indie','pct'=>15,'col'=>'#22c55e'],
                    ];
                @endphp
                @foreach($categories as $cat)
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1" style="font-size:0.8rem">
                        <span>{{ $cat['name'] }}</span>
                        <span style="color:var(--text-muted)">{{ $cat['pct'] }}%</span>
                    </div>
                    <div style="height:6px; background:rgba(255,255,255,0.06); border-radius:3px; overflow:hidden">
                        <div style="height:100%; width:{{ $cat['pct'] }}%; background:{{ $cat['col'] }}; border-radius:3px; transition:width 1s ease"></div>
                    </div>
                </div>
                @endforeach
                <div class="mt-3" style="font-size:0.78rem; color:var(--text-muted); text-align:center; padding-top:10px; border-top:1px solid var(--border)">
                    Data berdasarkan event aktif saat ini
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
{{--
=======================================================================
GANTI bagian <nav class="sidebar-nav"> ... </nav> di layouts/app.blade.php
dengan kode ini.
=======================================================================
--}}

<nav class="sidebar-nav">

{{-- ============ ADMIN MENU ============ --}}
@if(Auth::user()->role == 'admin')

    <div class="nav-section-label">Main</div>

    <div class="nav-item">
        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Dashboard</span>
        </a>
    </div>

    <div class="nav-item">
        <a href="{{ route('events.index') }}"
           class="nav-link {{ request()->routeIs('events.*') ? 'active' : '' }}">
            <i class="bi bi-music-note-beamed"></i>
            <span>Events</span>
        </a>
    </div>

    <div class="nav-item">
        <a href="{{ route('tiket.index') }}"
           class="nav-link {{ request()->routeIs('tiket.*') ? 'active' : '' }}">
            <i class="bi bi-ticket-perforated-fill"></i>
            <span>Tiket</span>
        </a>
    </div>

    <div class="nav-section-label">Kelola</div>

    <div class="nav-item">
        <a href="{{ route('transaksi.index') }}"
           class="nav-link {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
            <i class="bi bi-receipt-cutoff"></i>
            <span>Transaksi</span>
            {{-- Badge jumlah pending --}}
            @php $pendingCount = \App\Models\Transaksi::where('status','Pending')->count(); @endphp
            @if($pendingCount > 0)
                <span class="badge rounded-pill ms-auto"
                      style="background:#f59e0b;color:#000;font-size:0.65rem">
                    {{ $pendingCount }}
                </span>
            @endif
        </a>
    </div>

    <div class="nav-item">
        <a href="{{ route('kategori.index') }}"
           class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
            <i class="bi bi-tag-fill"></i>
            <span>Kategori</span>
        </a>
    </div>

    <div class="nav-item">
        <a href="{{ route('lokasi.index') }}"
           class="nav-link {{ request()->routeIs('lokasi.*') ? 'active' : '' }}">
            <i class="bi bi-geo-alt-fill"></i>
            <span>Lokasi</span>
        </a>
    </div>

    <div class="nav-item">
        <a href="{{ route('users.index') }}"
           class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i>
            <span>Pengguna</span>
        </a>
    </div>

    <div class="nav-item">
        <a href="{{ route('laporan.index') }}"
           class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line-fill"></i>
            <span>Laporan</span>
        </a>
    </div>

{{-- ============ USER MENU ============ --}}
@else

    <div class="nav-section-label">Portal Pengguna</div>

    <div class="nav-item">
        <a href="{{ route('user.home') }}"
           class="nav-link {{ request()->routeIs('user.home') ? 'active' : '' }}">
            <i class="bi bi-house-fill"></i>
            <span>Beranda</span>
        </a>
    </div>

    <div class="nav-item">
        <a href="{{ route('user.events') }}"
           class="nav-link {{ request()->routeIs('user.events') ? 'active' : '' }}">
            <i class="bi bi-music-note-beamed"></i>
            <span>Jelajahi Event</span>
        </a>
    </div>

    {{-- ★ Riwayat Pembelian (HANYA bisa lihat milik sendiri) --}}
    <div class="nav-item">
        <a href="{{ route('user.riwayat') }}"
           class="nav-link {{ request()->routeIs('user.riwayat') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i>
            <span>Riwayat Pembelian</span>
        </a>
    </div>

    {{-- USER TIDAK ADA menu: tambah event, edit event, hapus event,
         kelola transaksi, kategori, lokasi, laporan --}}

@endif

</nav>
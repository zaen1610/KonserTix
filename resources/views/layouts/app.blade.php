<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KonserTix') — Sistem Tiket Konser</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        /* ========== CSS VARIABLES ========== */
        :root {
            --bg-base:      #07080d;
            --bg-card:      #0e0f18;
            --bg-card2:     #13141f;
            --accent-1:     #a855f7;
            --accent-2:     #6366f1;
            --accent-gold:  #f59e0b;
            --text-primary: #f1f0f8;
            --text-muted:   #6b6d8a;
            --border:       rgba(168, 85, 247, 0.15);
            --glow:         0 0 40px rgba(168, 85, 247, 0.25);
            --glow-sm:      0 0 20px rgba(168, 85, 247, 0.15);
            --sidebar-w:    260px;
            --font-head:    'Syne', sans-serif;
            --font-body:    'DM Sans', sans-serif;
            --radius:       16px;
            --radius-sm:    10px;
        }

        /* ========== BASE ========== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: var(--bg-base);
            color: var(--text-primary);
            font-family: var(--font-body);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            position: fixed;
            left: 0; top: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--bg-card);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: var(--accent-1); border-radius: 4px; }

        /* Logo */
        .sidebar-logo {
            padding: 28px 24px 20px;
            border-bottom: 1px solid var(--border);
        }
        .sidebar-logo .brand {
            font-family: var(--font-head);
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(90deg, var(--accent-1), var(--accent-2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar-logo .brand-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--accent-1), var(--accent-2));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            -webkit-text-fill-color: white;
        }
        .sidebar-logo small {
            display: block;
            font-family: var(--font-body);
            font-size: 0.7rem;
            color: var(--text-muted);
            margin-top: 2px;
            -webkit-text-fill-color: var(--text-muted);
            letter-spacing: 0.05em;
        }

        /* Nav groups */
        .sidebar-nav { padding: 16px 12px; flex: 1; }
        .nav-section-label {
            font-size: 0.65rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 8px 12px 6px;
            font-weight: 600;
        }

        .nav-item { margin-bottom: 2px; }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: var(--radius-sm);
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            position: relative;
        }
        .nav-link i { font-size: 1.05rem; flex-shrink: 0; width: 20px; text-align: center; }
        .nav-link:hover {
            color: var(--text-primary);
            background: rgba(168, 85, 247, 0.08);
        }
        .nav-link.active {
            color: white;
            background: linear-gradient(90deg, rgba(168,85,247,0.2), rgba(99,102,241,0.15));
            box-shadow: inset 3px 0 0 var(--accent-1);
        }
        .nav-link.active i { color: var(--accent-1); }

        /* Sidebar footer */
        .sidebar-footer {
            padding: 16px 12px 20px;
            border-top: 1px solid var(--border);
        }
        .user-chip {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: var(--radius-sm);
            background: var(--bg-card2);
            margin-bottom: 8px;
        }
        .user-avatar {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, var(--accent-1), var(--accent-2));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem; font-weight: 700; color: white;
            flex-shrink: 0;
        }
        .user-name { font-size: 0.8rem; font-weight: 600; }
        .user-role { font-size: 0.68rem; color: var(--text-muted); }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 10px 14px;
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: var(--radius-sm);
            background: transparent;
            color: #ef4444;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-logout:hover { background: rgba(239, 68, 68, 0.1); }

        /* ========== TOPBAR ========== */
        .main-content { margin-left: var(--sidebar-w); min-height: 100vh; }

        .topbar {
            position: sticky; top: 0; z-index: 900;
            background: rgba(7, 8, 13, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .topbar-title {
            font-family: var(--font-head);
            font-size: 1.1rem;
            font-weight: 700;
        }
        .topbar-right { display: flex; align-items: center; gap: 12px; }

        .search-box {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--bg-card2);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 8px 14px;
        }
        .search-box i { color: var(--text-muted); font-size: 0.9rem; }
        .search-box input {
            background: none; border: none; outline: none;
            color: var(--text-primary); font-size: 0.875rem;
            width: 200px;
            font-family: var(--font-body);
        }
        .search-box input::placeholder { color: var(--text-muted); }

        .notif-btn {
            width: 38px; height: 38px;
            background: var(--bg-card2);
            border: 1px solid var(--border);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.2s;
        }
        .notif-btn:hover { color: var(--accent-1); border-color: var(--accent-1); }

        /* ========== PAGE CONTENT ========== */
        .page-content { padding: 28px; }

        /* ========== CARDS ========== */
        .card-dark {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
        }
        .card-dark .card-header {
            background: var(--bg-card2);
            border-bottom: 1px solid var(--border);
            padding: 16px 20px;
            border-radius: var(--radius) var(--radius) 0 0;
        }
        .card-dark .card-body { padding: 20px; }

        /* Stat cards */
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 22px;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 120px; height: 120px;
            border-radius: 50%;
            opacity: 0.06;
        }
        .stat-card.purple::before { background: var(--accent-1); }
        .stat-card.indigo::before { background: var(--accent-2); }
        .stat-card.gold::before { background: var(--accent-gold); }
        .stat-card.green::before { background: #22c55e; }

        .stat-card:hover { transform: translateY(-4px); box-shadow: var(--glow-sm); }
        .stat-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
            margin-bottom: 14px;
        }
        .stat-card.purple .stat-icon { background: rgba(168,85,247,0.15); color: var(--accent-1); }
        .stat-card.indigo .stat-icon { background: rgba(99,102,241,0.15); color: var(--accent-2); }
        .stat-card.gold   .stat-icon { background: rgba(245,158,11,0.15); color: var(--accent-gold); }
        .stat-card.green  .stat-icon { background: rgba(34,197,94,0.15);  color: #22c55e; }

        .stat-value {
            font-family: var(--font-head);
            font-size: 1.9rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 4px;
        }
        .stat-label { font-size: 0.8rem; color: var(--text-muted); }

        /* ========== TABLE ========== */
        .table-dark-custom {
            color: var(--text-primary);
            font-size: 0.875rem;
        }
        .table-dark-custom thead th {
            background: var(--bg-card2);
            color: var(--text-muted);
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            border-top: none;
        }
        .table-dark-custom tbody td {
            background: transparent;
            padding: 13px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.04);
            vertical-align: middle;
        }
        .table-dark-custom tbody tr:hover td {
            background: rgba(168, 85, 247, 0.04);
        }
        .table-dark-custom tbody tr:last-child td { border-bottom: none; }

        /* ========== BUTTONS ========== */
        .btn-primary-glow {
            background: linear-gradient(90deg, var(--accent-1), var(--accent-2));
            color: white;
            border: none;
            padding: 9px 20px;
            border-radius: var(--radius-sm);
            font-size: 0.875rem;
            font-weight: 500;
            font-family: var(--font-body);
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }
        .btn-primary-glow:hover { opacity: 0.85; color: white; transform: translateY(-1px); box-shadow: var(--glow-sm); }

        .btn-outline-soft {
            background: transparent;
            color: var(--text-primary);
            border: 1px solid var(--border);
            padding: 8px 18px;
            border-radius: var(--radius-sm);
            font-size: 0.875rem;
            font-family: var(--font-body);
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }
        .btn-outline-soft:hover { border-color: var(--accent-1); color: var(--accent-1); }

        .btn-danger-soft {
            background: transparent;
            color: #ef4444;
            border: 1px solid rgba(239,68,68,0.3);
            padding: 7px 14px;
            border-radius: var(--radius-sm);
            font-size: 0.8rem;
            font-family: var(--font-body);
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-danger-soft:hover { background: rgba(239,68,68,0.1); }

        .btn-edit-soft {
            background: rgba(99,102,241,0.12);
            color: var(--accent-2);
            border: none;
            padding: 7px 14px;
            border-radius: var(--radius-sm);
            font-size: 0.8rem;
            font-family: var(--font-body);
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-edit-soft:hover { background: rgba(99,102,241,0.2); color: var(--accent-2); }

        /* btn-neon untuk user */
        .btn-neon {
            background: linear-gradient(90deg, var(--accent-1), var(--accent-2));
            color: white;
            border: none;
            padding: 9px 20px;
            border-radius: var(--radius-sm);
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }
        .btn-neon:hover { opacity: 0.85; color: white; transform: translateY(-1px); box-shadow: var(--glow-sm); }

        /* card-neon untuk user */
        .card-neon {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
            margin-bottom: 16px;
        }

        /* ========== FORMS ========== */
        .form-group { margin-bottom: 18px; }
        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 7px;
            letter-spacing: 0.04em;
        }
        .form-control-dark {
            width: 100%;
            background: var(--bg-base);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text-primary);
            padding: 10px 14px;
            font-size: 0.875rem;
            font-family: var(--font-body);
            transition: border-color 0.2s;
            outline: none;
        }
        .form-control-dark:focus {
            border-color: var(--accent-1);
            box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.12);
        }
        .form-control-dark::placeholder { color: var(--text-muted); }

        /* ========== BADGES ========== */
        .badge-purple {
            background: rgba(168,85,247,0.15);
            color: var(--accent-1);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
        }
        .badge-indigo {
            background: rgba(99,102,241,0.15);
            color: var(--accent-2);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
        }
        .badge-gold {
            background: rgba(245,158,11,0.15);
            color: var(--accent-gold);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
        }
        .badge-green {
            background: rgba(34,197,94,0.15);
            color: #22c55e;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
        }
        .badge-red {
            background: rgba(239,68,68,0.15);
            color: #ef4444;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
        }

        /* ========== PAGE HEADER ========== */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .page-header-title {
            font-family: var(--font-head);
            font-size: 1.5rem;
            font-weight: 700;
        }
        .page-header-sub { font-size: 0.8rem; color: var(--text-muted); margin-top: 4px; }

        /* ========== ALERTS ========== */
        .alert-success-dark {
            background: rgba(34,197,94,0.1);
            border: 1px solid rgba(34,197,94,0.3);
            color: #4ade80;
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            margin-bottom: 20px;
            font-size: 0.875rem;
        }
        .alert-error-dark {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.3);
            color: #f87171;
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            margin-bottom: 20px;
            font-size: 0.875rem;
        }

        /* ========== BREADCRUMB ========== */
        .breadcrumb-dark { display: flex; gap: 8px; align-items: center; font-size: 0.8rem; color: var(--text-muted); margin-bottom: 6px; }
        .breadcrumb-dark a { color: var(--text-muted); text-decoration: none; }
        .breadcrumb-dark a:hover { color: var(--accent-1); }
        .breadcrumb-dark .current { color: var(--text-primary); }

        /* ========== EMPTY STATE ========== */
        .empty-state { text-align: center; padding: 60px 20px; color: var(--text-muted); }
        .empty-state i { font-size: 2.5rem; margin-bottom: 12px; opacity: 0.4; display: block; }
        .empty-state p { font-size: 0.875rem; }

        /* hero untuk user home */
        .hero {
            padding: 28px;
            background: linear-gradient(135deg, rgba(168,85,247,0.15), rgba(99,102,241,0.1));
            border: 1px solid var(--border);
            border-radius: var(--radius);
            margin-bottom: 28px;
        }
        .hero h1 { font-family: var(--font-head); font-size: 1.8rem; font-weight: 800; margin-bottom: 8px; }
        .hero p { color: var(--text-muted); }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 992px) {
            .sidebar { width: 70px; }
            .sidebar-logo .brand span, .sidebar-logo small,
            .nav-link span, .nav-section-label,
            .user-name, .user-role, .btn-logout span { display: none; }
            .sidebar-logo { padding: 20px 16px; }
            .main-content { margin-left: 70px; }
            .topbar { padding: 12px 16px; }
            .page-content { padding: 16px; }
            .search-box { display: none; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- ========== SIDEBAR ========== --}}
<aside class="sidebar">

    {{-- Logo --}}
    <div class="sidebar-logo">
        <div class="brand">
            <div class="brand-icon">🎵</div>
            <div>
                <span>KonserTix</span>
                <small>Ticket Management</small>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="sidebar-nav">

    @if(Auth::user()->role == 'admin')

        {{-- ===== MENU ADMIN ===== --}}
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

    @else

        {{-- ===== MENU USER ===== --}}
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
                <span>Lihat Event</span>
            </a>
        </div>

        <div class="nav-item">
            <a href="{{ route('user.riwayat') }}"
               class="nav-link {{ request()->routeIs('user.riwayat') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>Riwayat Pembelian</span>
            </a>
        </div>

    @endif

    </nav>

    {{-- Footer --}}
    <div class="sidebar-footer">
        <div class="user-chip">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
            </div>
            <div>
                <div class="user-name">{{ Auth::user()->name ?? 'Admin' }}</div>
                <div class="user-role">{{ ucfirst(Auth::user()->role ?? 'admin') }}</div>
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="bi bi-box-arrow-left"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>

{{-- ========== MAIN CONTENT ========== --}}
<div class="main-content">

    {{-- Topbar --}}
    <header class="topbar">
        <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
        <div class="topbar-right">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Cari sesuatu...">
            </div>
            <div class="notif-btn">
                <i class="bi bi-bell"></i>
            </div>
        </div>
    </header>

    {{-- Page Content --}}
    <main class="page-content">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert-success-dark">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert-error-dark">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>

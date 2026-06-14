@extends('layouts.app')
@section('title', 'Daftar Events')
@section('page-title', 'Events')

@section('content')
<div class="page-header">
    <div>
        <div class="breadcrumb-dark">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <i class="bi bi-chevron-right" style="font-size:0.6rem"></i>
            <span class="current">Events</span>
        </div>
        <div class="page-header-title">Daftar Events 🎤</div>
        <div class="page-header-sub">Kelola semua event konser yang terdaftar di sistem</div>
    </div>
    <a href="{{ route('events.create') }}" class="btn-primary-glow">
        <i class="bi bi-plus-lg"></i> Tambah Event
    </a>
</div>

{{-- Filter Bar --}}
<div class="card-dark mb-3">
    <div class="card-body" style="padding:14px 20px">
        <div class="d-flex gap-3 flex-wrap align-items-center">
            <div style="position:relative; flex:1; min-width:220px">
                <i class="bi bi-search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:var(--text-muted); font-size:0.85rem"></i>
                <input type="text" class="form-control-dark" placeholder="Cari nama event..."
                    style="padding-left:36px" id="searchInput" onkeyup="filterTable()">
            </div>
            <select class="form-control-dark" style="width:auto" id="filterKategori" onchange="filterTable()">
                <option value="">Semua Kategori</option>
                @foreach($kategoris ?? [] as $k)
                <option value="{{ $k->nama_kategori }}">{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
            <div style="font-size:0.8rem; color:var(--text-muted)">
                Total: <strong style="color:var(--text-primary)" id="rowCount">{{ count($events ?? []) }}</strong> event
            </div>
        </div>
    </div>
</div>

<div class="card-dark">
    <div class="card-body" style="padding:0">
        <div class="table-responsive">
            <table class="table table-dark-custom mb-0" id="eventsTable">
                <thead>
                    <tr>
                        <th style="width:40px">#</th>
                        <th>Nama Event</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Tiket</th>
                        <th style="width:160px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events ?? [] as $i => $event)
                    <tr>
                        <td style="color:var(--text-muted)">{{ $i + 1 }}</td>
                        <td>
                            <div style="font-weight:600">{{ $event->nama_event }}</div>
                            @if($event->deskripsi)
                            <div style="font-size:0.72rem; color:var(--text-muted); margin-top:2px">
                                {{ Str::limit($event->deskripsi, 50) }}
                            </div>
                            @endif
                        </td>
                        <td>
                            @if($event->kategori)
                            <span class="badge-purple">{{ $event->kategori->nama_kategori }}</span>
                            @else
                            <span style="color:var(--text-muted)">—</span>
                            @endif
                        </td>
                        <td>
                            @if($event->lokasi)
                            <div style="font-size:0.875rem">{{ $event->lokasi->nama_lokasi }}</div>
                            <div style="font-size:0.72rem; color:var(--text-muted)">{{ $event->lokasi->alamat }}</div>
                            @else
                            <span style="color:var(--text-muted)">—</span>
                            @endif
                        </td>
                        <td>
                            @if($event->tanggal)
                            <span style="font-size:0.875rem">
                                {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}
                            </span>
                            @else —
                            @endif
                        </td>
                        <td>{{ $event->jam ?? '—' }}</td>
                        <td>
                            <span class="badge-indigo">
                                {{ $event->tikets->count() ?? 0 }} jenis
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('events.show', $event->id) }}" class="btn-edit-soft" title="Detail">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="{{ route('events.edit', $event->id) }}" class="btn-edit-soft" title="Edit">
                                    <i class="bi bi-pencil-fill"></i> Edit
                                </a>
                                <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus event ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger-soft" title="Hapus">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="bi bi-music-note-beamed"></i>
                                <p>Belum ada event. <a href="{{ route('events.create') }}" style="color:var(--accent-1)">Tambah sekarang</a></p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
function filterTable() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const kategori = document.getElementById('filterKategori').value.toLowerCase();
    const rows = document.querySelectorAll('#eventsTable tbody tr');
    let count = 0;
    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        const matchSearch = !search || text.includes(search);
        const matchKategori = !kategori || text.includes(kategori);
        if (matchSearch && matchKategori) { row.style.display = ''; count++; }
        else { row.style.display = 'none'; }
    });
    document.getElementById('rowCount').textContent = count;
}
</script>
@endpush
@endsection
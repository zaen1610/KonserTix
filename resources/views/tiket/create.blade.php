    @extends('layouts.app')
    @section('title', 'Tambah Tiket')
    @section('page-title', 'Tambah Tiket')

    @section('content')
    <div class="page-header">
        <div>
            <div class="breadcrumb-dark">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <i class="bi bi-chevron-right" style="font-size:0.6rem"></i>
                <a href="{{ route('tiket.index') }}">Tiket</a>
                <i class="bi bi-chevron-right" style="font-size:0.6rem"></i>
                <span class="current">Tambah</span>
            </div>
            <div class="page-header-title">Tambah Tiket Baru</div>
            <div class="page-header-sub">Buat jenis tiket baru untuk suatu event</div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-7">
            <div class="card-dark">
                <div class="card-header">
                    <div style="font-family:var(--font-head); font-weight:700">Form Tiket</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('tiket.store') }}" method="POST">
                        @csrf

                        @if($errors->any())
                        <div class="alert-error-dark">
                            @foreach($errors->all() as $e) <div>{{ $e }}</div> @endforeach
                        </div>
                        @endif

                        <div class="form-group">
                            <label class="form-label">Event *</label>
                            <select name="event_id" class="form-control-dark" required>
                                <option value="">-- Pilih Event --</option>
                                @foreach($events ?? [] as $event)
                                <option value="{{ $event->id }}"
                                    {{ (old('event_id') == $event->id || request('event_id') == $event->id) ? 'selected' : '' }}>
                                    {{ $event->nama_event }} — {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jenis Tiket *</label>
                            <div class="d-flex gap-2 mb-2 flex-wrap">
                                @foreach(['VVIP','VIP','Festival','Reguler','Early Bird'] as $j)
                                <button type="button" class="quick-jenis-btn"
                                    style="padding:6px 14px; border-radius:20px; border:1px solid var(--border); background:transparent; color:var(--text-muted); font-size:0.78rem; cursor:pointer; transition:all 0.2s; font-family:var(--font-body)"
                                    onclick="setJenis('{{ $j }}')">{{ $j }}</button>
                                @endforeach
                            </div>
                            <input type="text" name="jenis" id="jenisInput" class="form-control-dark"
                                placeholder="atau ketik sendiri, cth: VIP" value="{{ old('jenis') }}" required>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Harga (Rp) *</label>
                                    <input type="number" name="harga" class="form-control-dark"
                                        placeholder="150000" min="0" value="{{ old('harga') }}" required
                                        oninput="updatePreview()">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Stok *</label>
                                    <input type="number" name="stok" class="form-control-dark"
                                        placeholder="100" min="1" value="{{ old('stok') }}" required>
                                </div>
                            </div>
                        </div>

                        {{-- Live preview --}}
                        <div class="card-dark mt-3 mb-3" id="ticketPreview" style="border:1px dashed var(--accent-1); background:rgba(168,85,247,0.05)">
                            <div class="card-body" style="display:flex; align-items:center; justify-content:space-between; padding:14px 18px">
                                <div>
                                    <div style="font-size:0.7rem; color:var(--text-muted); letter-spacing:0.08em">TIKET PREVIEW</div>
                                    <div style="font-weight:700; font-family:var(--font-head)" id="prevJenis">—</div>
                                </div>
                                <div style="text-align:right">
                                    <div style="font-size:0.72rem; color:var(--text-muted)">Harga</div>
                                    <div style="font-weight:700; color:var(--accent-gold)" id="prevHarga">Rp —</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-3 mt-4" style="padding-top:16px; border-top:1px solid var(--border)">
                            <button type="submit" class="btn-primary-glow">
                                <i class="bi bi-check-lg"></i> Simpan Tiket
                            </button>
                            <a href="{{ route('tiket.index') }}" class="btn-outline-soft">
                                <i class="bi bi-x-lg"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card-dark">
                <div class="card-header"><div style="font-family:var(--font-head); font-weight:700; font-size:0.9rem">Panduan Harga</div></div>
                <div class="card-body">
                    <div style="font-size:0.8rem; color:var(--text-muted)">Rekomendasi harga tiket konser Indonesia:</div>
                    <table class="table table-dark-custom mt-2" style="font-size:0.8rem">
                        <tbody>
                            @foreach([['VVIP','Rp 500.000 - 2.000.000'],['VIP','Rp 300.000 - 800.000'],['Festival','Rp 150.000 - 400.000'],['Reguler','Rp 50.000 - 200.000'],['Early Bird','Rp 100.000 - 300.000']] as $r)
                            <tr>
                                <td><span class="badge-purple">{{ $r[0] }}</span></td>
                                <td style="color:var(--accent-gold)">{{ $r[1] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    function setJenis(j) {
        document.getElementById('jenisInput').value = j;
        document.getElementById('prevJenis').textContent = j;
    }
    function updatePreview() {
        const h = document.querySelector('[name=harga]').value;
        document.getElementById('prevHarga').textContent = h ? 'Rp'+parseInt(h).toLocaleString('id') : 'Rp —';
    }
    document.getElementById('jenisInput').addEventListener('input', function() {
        document.getElementById('prevJenis').textContent = this.value || '—';
    });
    </script>
    @endpush
    @endsection
```php
@extends('layouts.app')
@section('title', 'Tambah Event')
@section('page-title', 'Tambah Event')

@section('content')
<div class="page-header">
    <div>
        <div class="breadcrumb-dark">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <i class="bi bi-chevron-right" style="font-size:0.6rem"></i>
            <a href="{{ route('events.index') }}">Events</a>
            <i class="bi bi-chevron-right" style="font-size:0.6rem"></i>
            <span class="current">Tambah</span>
        </div>

        <div class="page-header-title">
            Tambah Event Baru
        </div>

        <div class="page-header-sub">
            Isi detail event konser yang akan diselenggarakan
        </div>
    </div>
</div>

<div class="row g-3">

    <div class="col-md-8">

        <div class="card-dark">

            <div class="card-header">
                <div style="font-family:var(--font-head); font-weight:700">
                    Informasi Event
                </div>
            </div>

            <div class="card-body">

                <form action="{{ route('events.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    @if($errors->any())
                    <div class="alert-error-dark">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>

                        <strong>Terdapat kesalahan:</strong>

                        <ul class="mb-0 mt-1 ps-3">
                            @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="row g-3">

                        <div class="col-12">
                            <div class="form-group">

                                <label class="form-label">
                                    Nama Event *
                                </label>

                                <input
                                    type="text"
                                    name="nama_event"
                                    class="form-control-dark"
                                    placeholder="Contoh: Coldplay World Tour"
                                    value="{{ old('nama_event') }}"
                                    required>

                            </div>
                        </div>

                        {{-- KATEGORI --}}
                        <div class="col-md-6">

                            <div class="form-group">

                                <label class="form-label">
                                    Pilih Kategori
                                </label>

                                <select
                                    name="kategori_id"
                                    class="form-control-dark">

                                    <option value="">
                                        -- Pilih Kategori --
                                    </option>

                                    @foreach($kategoris ?? [] as $k)
                                    <option value="{{ $k->id }}">
                                        {{ $k->nama_kategori }}
                                    </option>
                                    @endforeach

                                </select>

                                <small
                                    style="display:block;
                                           margin-top:8px;
                                           color:var(--text-muted)">
                                    Atau isi kategori baru
                                </small>

                                <input
                                    type="text"
                                    name="kategori"
                                    class="form-control-dark mt-2"
                                    placeholder="Contoh: Konser Musik">
                            </div>

                        </div>

                        {{-- LOKASI --}}
                        <div class="col-md-6">

                            <div class="form-group">

                                <label class="form-label">
                                    Pilih Lokasi
                                </label>

                                <select
                                    name="lokasi_id"
                                    class="form-control-dark">

                                    <option value="">
                                        -- Pilih Lokasi --
                                    </option>

                                    @foreach($lokasis ?? [] as $l)
                                    <option value="{{ $l->id }}">
                                        {{ $l->nama_lokasi }}
                                    </option>
                                    @endforeach

                                </select>

                                <small
                                    style="display:block;
                                           margin-top:8px;
                                           color:var(--text-muted)">
                                    Atau isi lokasi baru
                                </small>

                                <input
                                    type="text"
                                    name="lokasi"
                                    class="form-control-dark mt-2"
                                    placeholder="Contoh: GBLA Bandung">

                                <textarea
                                    name="alamat"
                                    rows="2"
                                    class="form-control-dark mt-2"
                                    placeholder="Alamat lokasi baru"></textarea>

                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">

                                <label class="form-label">
                                    Tanggal Event *
                                </label>

                                <input
                                    type="date"
                                    name="tanggal"
                                    class="form-control-dark"
                                    value="{{ old('tanggal') }}"
                                    required>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">

                                <label class="form-label">
                                    Jam Mulai *
                                </label>

                                <input
                                    type="time"
                                    name="jam"
                                    class="form-control-dark"
                                    value="{{ old('jam') }}"
                                    required>

                            </div>
                        </div>

                        <div class="col-12">

                            <div class="form-group">

                                <label class="form-label">
                                    Deskripsi Event *
                                </label>

                                <textarea
                                    name="deskripsi"
                                    rows="4"
                                    class="form-control-dark"
                                    required>{{ old('deskripsi') }}</textarea>

                            </div>

                        </div>

                        <div class="col-12">

                            <div class="form-group">

                                <label class="form-label">
                                    Poster Event
                                </label>

                                <input
                                    type="file"
                                    name="poster"
                                    class="form-control-dark"
                                    accept="image/*"
                                    id="posterInput"
                                    onchange="previewImage(this)">

                                <div
                                    id="posterPreview"
                                    style="display:none;
                                           margin-top:12px">

                                    <img
                                        id="previewImg"
                                        style="max-width:200px;
                                               border-radius:10px;
                                               border:1px solid var(--border)">
                                </div>

                            </div>

                        </div>

                    </div>

                    <div
                        class="d-flex gap-3 mt-4"
                        style="padding-top:16px;
                               border-top:1px solid var(--border)">

                        <button
                            type="submit"
                            class="btn-primary-glow">

                            <i class="bi bi-check-lg"></i>
                            Simpan Event

                        </button>

                        <a
                            href="{{ route('events.index') }}"
                            class="btn-outline-soft">

                            <i class="bi bi-x-lg"></i>
                            Batal

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@push('scripts')
<script>
function previewImage(input)
{
    if (input.files && input.files[0])
    {
        const reader = new FileReader();

        reader.onload = function(e)
        {
            document.getElementById('previewImg').src =
                e.target.result;

            document.getElementById('posterPreview').style.display =
                'block';
        }

        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush

@endsection
```

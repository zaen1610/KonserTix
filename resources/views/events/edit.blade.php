@extends('layouts.app')

@section('title','Edit Event')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-warning">

            <h4>Edit Event</h4>

        </div>

        <div class="card-body">

            @if ($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form
                action="{{ route('events.update',$event->id) }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label>Nama Event</label>

                    <input
                        type="text"
                        name="nama_event"
                        class="form-control"
                        value="{{ old('nama_event',$event->nama_event) }}"
                        required>

                </div>

                <div class="mb-3">

                    <label>Kategori</label>

                    <select
                        name="kategori_event_id"
                        class="form-control"
                        required>

                        @foreach($kategori as $k)

                            <option
                                value="{{ $k->id }}"
                                {{ $event->kategori_event_id==$k->id ? 'selected':'' }}>

                                {{ $k->nama_kategori }}


                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label>Lokasi</label>

                    <select
                        name="lokasi_id"
                        class="form-control"
                        required>

                        @foreach($lokasi as $l)

                            <option
                                value="{{ $l->id }}"
                                {{ $event->lokasi_id==$l->id ? 'selected':'' }}>

                                {{ $l->nama_lokasi }}


                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label>Tanggal</label>

                    <input
                        type="date"
                        name="tanggal"
                        class="form-control"
                        value="{{ old('tanggal',$event->tanggal) }}"
                        required>

                </div>

                <div class="mb-3">

                    <label>Deskripsi</label>

                    <textarea
                        name="deskripsi"
                        rows="5"
                        class="form-control"
                        required>{{ old('deskripsi',$event->deskripsi) }}</textarea>

                </div>

                <div class="mb-3">

                    <label>Gambar Lama</label>

                    <br>

                    @if($event->gambar)

                        <img
                            src="{{ asset('storage/'.$event->gambar) }}"
                            width="250"
                            class="img-thumbnail">

                    @else

                        <p>Tidak ada gambar.</p>

                    @endif

                </div>

                <div class="mb-3">

                    <label>Ganti Gambar</label>

                    <input
                        type="file"
                        name="gambar"
                        class="form-control">

                </div>

                <button
                    class="btn btn-success">

                    Update

                </button>

                <a
                    href="{{ route('events.index') }}"
                    class="btn btn-secondary">

                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>

@endsection
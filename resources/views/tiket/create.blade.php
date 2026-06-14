@extends('layouts.app')

@section('title','Tambah Tiket')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h4>Tambah Tiket</h4>
        </div>

        <div class="card-body">

            @if($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form action="{{ route('tiket.store') }}" method="POST">

                @csrf

                <div class="mb-3">

                    <label>Event</label>

                    <select
                        name="event_id"
                        class="form-control"
                        required>

                        <option value="">Pilih Event</option>

                        @foreach($events as $event)

                            <option value="{{ $event->id }}">

                                {{ $event->nama_event }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label>Jenis Tiket</label>

                    <input
                        type="text"
                        name="jenis"
                        class="form-control"
                        placeholder="VIP / Festival / Reguler"
                        required>

                </div>

                <div class="mb-3">

                    <label>Harga</label>

                    <input
                        type="number"
                        name="harga"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label>Stok</label>

                    <input
                        type="number"
                        name="stok"
                        class="form-control"
                        required>

                </div>

                <button class="btn btn-success">

                    Simpan

                </button>

                <a
                    href="{{ route('tiket.index') }}"
                    class="btn btn-secondary">

                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>

@endsection
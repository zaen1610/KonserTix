@extends('layouts.app')

@section('title','Daftar Event')

@section('content')

<div class="container">

    <h2 class="mb-4 fw-bold">
        🎵 Daftar Event
    </h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">

        @forelse($events as $event)

            <div class="col-lg-4 col-md-6 mb-4">

                <div class="card shadow h-100">

                    @if($event->gambar)

                        <img
                            src="{{ asset('storage/'.$event->gambar) }}"
                            class="card-img-top"
                            style="height:220px;object-fit:cover;">

                    @else

                        <img
                            src="https://via.placeholder.com/500x250?text=Konser"
                            class="card-img-top">

                    @endif

                    <div class="card-body">

                        <h4 class="fw-bold">
                            {{ $event->nama_event }}
                        </h4>

                        <hr>

                        <p>

                            <strong>Kategori :</strong>

                            {{ $event->kategori->nama ?? '-' }}

                        </p>

                        <p>

                            <strong>Lokasi :</strong>

                            {{ $event->lokasi->nama ?? '-' }}

                        </p>

                        <p>

                            <strong>Tanggal :</strong>

                            {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}

                        </p>

                        @if($event->tiket)

                            <hr>

                            <p>

                                <strong>Jenis Tiket</strong>

                                <br>

                                {{ $event->tiket->jenis }}

                            </p>

                            <p>

                                <strong>Harga</strong>

                                <br>

                                Rp {{ number_format($event->tiket->harga,0,',','.') }}

                            </p>

                            <p>

                                <strong>Stok</strong>

                                <br>

                                @if($event->tiket->stok>0)

                                    <span class="badge bg-success">

                                        {{ $event->tiket->stok }} Tiket

                                    </span>

                                @else

                                    <span class="badge bg-danger">

                                        Habis

                                    </span>

                                @endif

                            </p>

                        @endif

                    </div>

                    <div class="card-footer bg-white">

                        <div class="d-grid gap-2">

                            <a
                                href="{{ route('user.event.show',$event->id) }}"
                                class="btn btn-primary">

                                Detail Event

                            </a>

                            @if($event->tiket)

                                @if($event->tiket->stok>0)

                                    <a
                                        href="{{ route('tiket.beli', $event->tiket->id) }}"
                                        class="btn btn-success w-100">

                                        🎫 Beli Tiket

                                    </a>



                                @else

                                    <button
                                        class="btn btn-danger"
                                        disabled>

                                        Tiket Habis

                                    </button>

                                @endif

                            @else

                                <button
                                    class="btn btn-secondary"
                                    disabled>

                                    Tiket Belum Tersedia

                                </button>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="alert alert-warning">

                    Belum ada event.

                </div>

            </div>

        @endforelse

    </div>

</div>

@endsection
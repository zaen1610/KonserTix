@extends('layouts.app')

@section('title','Beranda User')

@section('content')

<div class="container">

    <div class="p-5 mb-4 bg-primary text-white rounded shadow">

        <h1 class="display-5 fw-bold">

            Selamat Datang,
            {{ auth()->user()->name }}

        </h1>

        <p class="lead">

            Temukan konser favoritmu dan beli tiket dengan mudah.

        </p>

        <a
            href="{{ route('user.events') }}"
            class="btn btn-light">

            Lihat Semua Event

        </a>

    </div>

    <h3 class="mb-4">

        🎵 Event Terbaru

    </h3>

    <div class="row">

        @forelse($events as $event)

            <div class="col-md-4 mb-4">

                <div class="card shadow h-100">

                    @if($event->gambar)

                        <img
                            src="{{ asset('storage/'.$event->gambar) }}"
                            class="card-img-top"
                            style="height:220px;object-fit:cover;">

                    @else

                        <img
                            src="https://via.placeholder.com/500x250"
                            class="card-img-top">

                    @endif

                    <div class="card-body">

                        <h5>

                            {{ $event->nama_event }}

                        </h5>

                        <hr>

                        <p>

                            <strong>Kategori</strong>

                            <br>

                            {{ $event->kategori->nama ?? '-' }}

                        </p>

                        <p>

                            <strong>Lokasi</strong>

                            <br>

                            {{ $event->lokasi->nama ?? '-' }}

                        </p>

                        <p>

                            <strong>Tanggal</strong>

                            <br>

                            {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}

                        </p>

                        @if($event->tiket)

                            <hr>

                            <p>

                                Harga

                                <br>

                                <strong>

                                    Rp {{ number_format($event->tiket->harga,0,',','.') }}

                                </strong>

                            </p>

                            <p>

                                Stok

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

                        <a
                            href="{{ route('user.event.show',$event->id) }}"
                            class="btn btn-primary w-100">

                            Lihat Detail

                        </a>

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
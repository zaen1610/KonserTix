@extends('layouts.app')

@section('title','Detail Event')

@section('content')

<div class="container">

    <div class="row">

        <div class="col-md-7">

            <div class="card shadow">

                @if($event->gambar)

                    <img
                        src="{{ asset('storage/'.$event->gambar) }}"
                        class="card-img-top"
                        style="height:400px;object-fit:cover;">

                @endif

                <div class="card-body">

                    <h2>

                        {{ $event->nama_event }}

                    </h2>

                    <hr>

                    <p>

                        <strong>Kategori</strong>

                        <br>

                        {{ $event->kategori->nama }}

                    </p>

                    <p>

                        <strong>Lokasi</strong>

                        <br>

                        {{ $event->lokasi->nama }}

                    </p>

                    <p>

                        <strong>Tanggal</strong>

                        <br>

                        {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}

                    </p>

                    <hr>

                    <p>

                        {{ $event->deskripsi }}

                    </p>

                </div>

            </div>

        </div>

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-body">

                    <h4>

                        Tiket

                    </h4>

                    <hr>

                    @if($event->tiket)

                        <p>

                            Jenis

                            <br>

                            <strong>

                                {{ $event->tiket->jenis }}

                            </strong>

                        </p>

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

                            <strong>

                                {{ $event->tiket->stok }}

                            </strong>

                        </p>

                        @if($event->tiket->stok>0)

                            <form
                                method="POST"
                                action="{{ route('tiket.beli',$event->tiket->id) }}">

                                @csrf

                                <button
                                    class="btn btn-success w-100">

                                    Beli Tiket

                                </button>

                            </form>

                        @else

                            <button
                                class="btn btn-danger w-100"
                                disabled>

                                Tiket Habis

                            </button>

                        @endif

                    @else

                        <div class="alert alert-warning">

                            Tiket belum tersedia.

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">
        Semua Event
    </h2>

    <div class="row">

        @forelse($events as $event)

            <div class="col-md-4 mb-4">

                <div class="card h-100">

                    @if($event->gambar)
                        <img src="{{ asset('storage/'.$event->gambar) }}"
                             class="card-img-top">
                    @endif

                    <div class="card-body">

                        <h5>{{ $event->nama_event }}</h5>

                        <p>
                            {{ $event->kategori->nama ?? '-' }}
                        </p>

                        <p>
                            {{ $event->lokasi->nama ?? '-' }}
                        </p>

                        <p>
                            {{ $event->tanggal }}
                        </p>

                        <a href="{{ route('events.show',$event->id) }}"
                           class="btn btn-primary">
                            Detail
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
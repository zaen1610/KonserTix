@extends('layouts.app')

@section('title', 'Edit Tiket')
@section('page-title', 'Edit Tiket')

@section('content')

<div class="card-dark">

    <div class="card-header">
        <h4>Edit Tiket</h4>
    </div>

    <div class="card-body">

        <form action="{{ route('tiket.update', $tiket->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Event</label>

                <select name="event_id" class="form-control-dark">

                    @foreach($events as $event)

                    <option value="{{ $event->id }}"
                        {{ $event->id == $tiket->event_id ? 'selected' : '' }}>

                        {{ $event->nama_event }}

                    </option>

                    @endforeach

                </select>
            </div>

            <div class="mb-3">
                <label>Jenis Tiket</label>

                <input type="text"
                       name="jenis"
                       value="{{ $tiket->jenis }}"
                       class="form-control-dark">
            </div>

            <div class="mb-3">
                <label>Harga</label>

                <input type="number"
                       name="harga"
                       value="{{ $tiket->harga }}"
                       class="form-control-dark">
            </div>

            <div class="mb-3">
                <label>Stok</label>

                <input type="number"
                       name="stok"
                       value="{{ $tiket->stok }}"
                       class="form-control-dark">
            </div>

            <button type="submit" class="btn-primary-glow">
                Update Tiket
            </button>

            <a href="{{ route('tiket.index') }}"
               class="btn-outline-soft">

               Kembali

            </a>

        </form>

    </div>

</div>

@endsection
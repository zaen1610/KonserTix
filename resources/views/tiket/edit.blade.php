@extends('layouts.app')

@section('title','Edit Tiket')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-warning">

            <h4>Edit Tiket</h4>

        </div>

        <div class="card-body">

            @if($errors->any())

                <div class="alert alert-danger">

                    <ul>

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form
                action="{{ route('tiket.update',$tiket->id) }}"
                method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label>Event</label>

                    <select
                        name="event_id"
                        class="form-control">

                        @foreach($events as $event)

                            <option
                                value="{{ $event->id }}"
                                {{ $tiket->event_id==$event->id ? 'selected':'' }}>

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
                        value="{{ old('jenis',$tiket->jenis) }}"
                        required>

                </div>

                <div class="mb-3">

                    <label>Harga</label>

                    <input
                        type="number"
                        name="harga"
                        class="form-control"
                        value="{{ old('harga',$tiket->harga) }}"
                        required>

                </div>

                <div class="mb-3">

                    <label>Stok</label>

                    <input
                        type="number"
                        name="stok"
                        class="form-control"
                        value="{{ old('stok',$tiket->stok) }}"
                        required>

                </div>

                <button class="btn btn-success">

                    Update

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
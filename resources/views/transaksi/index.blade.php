@extends('layouts.app')

@section('title','Data Transaksi')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>📄 Data Transaksi</h2>

        <a href="{{ route('transaksi.create') }}"
            class="btn btn-primary">

            + Tambah Transaksi

        </a>

    </div>

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

    <div class="card shadow">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">

                        <tr>

                            <th>No</th>

                            <th>Nama Pembeli</th>

                            <th>Event</th>

                            <th>Jenis Tiket</th>

                            <th>Jumlah</th>

                            <th>Total</th>

                            <th>Status</th>

                            <th width="260">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($transaksis as $no => $transaksi)

                        <tr>

                            <td>

                                {{ ($transaksis->firstItem()-1)+$no }}

                            </td>

                            <td>

                                {{ !empty($transaksi->nama_pembeli) ? $transaksi->nama_pembeli : '-' }}

                            </td>

                            <td>

                                {{ $transaksi->tiket->event->nama_event ?? '-' }}

                            </td>

                            <td>

                                {{ $transaksi->tiket->jenis ?? '-' }}

                            </td>

                            <td>

                                {{ $transaksi->jumlah }}

                            </td>

                            <td>

                                Rp {{ number_format($transaksi->total_harga,0,',','.') }}

                            </td>

                            <td>

                                @if($transaksi->status=="Pending")

                                    <span class="badge bg-warning text-dark">

                                        Pending

                                    </span>

                                @elseif($transaksi->status=="Confirmed")

                                    <span class="badge bg-success">

                                        Confirmed

                                    </span>

                                @elseif($transaksi->status=="Rejected")

                                    <span class="badge bg-danger">

                                        Rejected

                                    </span>

                                @else

                                    <span class="badge bg-secondary">

                                        {{ $transaksi->status }}

                                    </span>

                                @endif

                            </td>

                            <td>

                                <div class="d-flex flex-wrap gap-1">

                                    <a
                                        href="{{ route('transaksi.show',$transaksi->id) }}"
                                        class="btn btn-info btn-sm">

                                        Detail

                                    </a>

                                    <a
                                        href="{{ route('transaksi.edit',$transaksi->id) }}"
                                        class="btn btn-warning btn-sm">

                                        Edit

                                    </a>

                                    @if($transaksi->status=="Pending")

                                        <form
                                            action="{{ route('transaksi.konfirmasi',$transaksi->id) }}"
                                            method="POST">

                                            @csrf

                                            @method('PATCH')

                                            <input
                                                type="hidden"
                                                name="status"
                                                value="Confirmed">

                                            <button
                                                class="btn btn-success btn-sm">

                                                Confirm

                                            </button>

                                        </form>

                                        <form
                                            action="{{ route('transaksi.konfirmasi',$transaksi->id) }}"
                                            method="POST">

                                            @csrf

                                            @method('PATCH')

                                            <input
                                                type="hidden"
                                                name="status"
                                                value="Rejected">

                                            <button
                                                class="btn btn-danger btn-sm">

                                                Reject

                                            </button>

                                        </form>

                                    @endif

                                    <form
                                        action="{{ route('transaksi.destroy',$transaksi->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus transaksi?')">

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            class="btn btn-secondary btn-sm">

                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" class="text-center">

                                Belum ada transaksi.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $transaksis->links() }}

            </div>

        </div>

    </div>

</div>

@endsection
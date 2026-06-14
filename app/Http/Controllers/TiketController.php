<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use App\Models\Event;
use Illuminate\Http\Request;

class TiketController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Daftar Tiket
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $tikets = Tiket::with('event')
            ->latest()
            ->paginate(10);

        return view('tiket.index', compact('tikets'));
    }

    /*
    |--------------------------------------------------------------------------
    | Form Tambah Tiket
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $events = Event::all();

        return view('tiket.create', compact('events'));
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan Tiket
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'event_id' => 'required|exists:events,id',

            'jenis' => 'required|string|max:100',

            'harga' => 'required|numeric|min:0',

            'stok' => 'required|integer|min:0'

        ]);

        Tiket::create([

            'event_id' => $request->event_id,

            'jenis' => $request->jenis,

            'harga' => $request->harga,

            'stok' => $request->stok

        ]);

        return redirect()
            ->route('tiket.index')
            ->with('success', 'Tiket berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | Detail Tiket
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $tiket = Tiket::with('event')
            ->findOrFail($id);

        return view('tiket.show', compact('tiket'));
    }

    /*
    |--------------------------------------------------------------------------
    | Form Edit
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $tiket = Tiket::findOrFail($id);

        $events = Event::all();

        return view(
            'tiket.edit',
            compact(
                'tiket',
                'events'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $request->validate([

            'event_id' => 'required|exists:events,id',

            'jenis' => 'required|string|max:100',

            'harga' => 'required|numeric|min:0',

            'stok' => 'required|integer|min:0'

        ]);

        $tiket = Tiket::findOrFail($id);

        $tiket->update([

            'event_id' => $request->event_id,

            'jenis' => $request->jenis,

            'harga' => $request->harga,

            'stok' => $request->stok

        ]);

        return redirect()
            ->route('tiket.index')
            ->with('success', 'Tiket berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | Hapus
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $tiket = Tiket::findOrFail($id);

        $tiket->delete();

        return redirect()
            ->route('tiket.index')
            ->with('success', 'Tiket berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | Tambah Stok
    |--------------------------------------------------------------------------
    */

    public function tambahStok(Request $request, $id)
    {
        $request->validate([

            'stok' => 'required|integer|min:1'

        ]);

        $tiket = Tiket::findOrFail($id);

        $tiket->increment(
            'stok',
            $request->stok
        );

        return back()->with(
            'success',
            'Stok berhasil ditambahkan.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Kurangi Stok
    |--------------------------------------------------------------------------
    */

    public function kurangiStok(Request $request, $id)
    {
        $request->validate([

            'stok' => 'required|integer|min:1'

        ]);

        $tiket = Tiket::findOrFail($id);

        if ($tiket->stok < $request->stok) {

            return back()->with(
                'error',
                'Stok tidak mencukupi.'
            );

        }

        $tiket->decrement(
            'stok',
            $request->stok
        );

        return back()->with(
            'success',
            'Stok berhasil dikurangi.'
        );
    }
}
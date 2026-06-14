<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use App\Models\Event;
use Illuminate\Http\Request;

class TiketController extends Controller
{
    public function index()
    {
        $tikets = Tiket::with('event')->get();

        return view('tiket.index', compact('tikets'));
    }

    public function create()
    {
        $events = Event::all();

        return view('tiket.create', compact('events'));
    }

  public function store(Request $request)
{
    $request->validate([
        'event_id' => 'required',
        'jenis'    => 'required',
        'harga'    => 'required|numeric',
        'stok'     => 'required|numeric'
    ]);

    Tiket::create([
        'event_id' => $request->event_id,
        'jenis'    => $request->jenis,
        'harga'    => $request->harga,
        'stok'     => $request->stok
    ]);

    return redirect()
        ->route('tiket.index')
        ->with('success', 'Tiket berhasil ditambahkan');
}
    public function edit($id)
    {
        $tiket = Tiket::findOrFail($id);
        $events = Event::all();

        return view(
            'tiket.edit',
            compact('tiket','events')
        );
    }

    public function update(Request $request,$id)
    {
        $tiket = Tiket::findOrFail($id);

        $tiket->update($request->all());

        return redirect()
            ->route('tiket.index');
    }

    public function destroy($id)
    {
        Tiket::destroy($id);

        return redirect()
            ->route('tiket.index');
    }
}
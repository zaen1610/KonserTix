<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\KategoriEvent;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $events = Event::with([
            'kategori',
            'lokasi',
            'tikets'
        ])->latest()->paginate(10);

        return view('events.index', compact('events'));
    }

    public function create()
    {
        $kategori = KategoriEvent::all();
        $lokasi   = Lokasi::all();

        return view('events.create', compact(
            'kategori',
            'lokasi'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([

            'nama_event' => 'required',

            'kategori_event_id' => 'required',

            'lokasi_id' => 'required',

            'tanggal' => 'required|date',

            'deskripsi' => 'required',

            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'

        ]);

        $gambar = null;

        if ($request->hasFile('gambar')) {

            $gambar = $request
                ->file('gambar')
                ->store('events', 'public');

        }

        Event::create([

            'nama_event' => $request->nama_event,

            'kategori_event_id' => $request->kategori_event_id,

            'lokasi_id' => $request->lokasi_id,

            'tanggal' => $request->tanggal,

            'deskripsi' => $request->deskripsi,

            'gambar' => $gambar

        ]);

        return redirect()
            ->route('events.index')
            ->with('success', 'Event berhasil ditambahkan.');
    }

    public function show($id)
    {
        $event = Event::with([
            'kategori',
            'lokasi',
            'tikets'
        ])->findOrFail($id);

        return view('events.show', compact('event'));
    }

    /*
    |--------------------------------------------------------------------------
    | USER
    |--------------------------------------------------------------------------
    */

    public function showUser($id)
{
    $event = Event::with([
        'kategori',
        'lokasi',
        'tiket'
    ])->findOrFail($id);

    return view('user.show', compact('event'));
}

    public function edit($id)
    {
        $event = Event::findOrFail($id);

        $kategori = KategoriEvent::all();

        $lokasi = Lokasi::all();

        return view(
            'events.edit',
            compact(
                'event',
                'kategori',
                'lokasi'
            )
        );
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([

            'nama_event' => 'required',

            'kategori_event_id' => 'required',

            'lokasi_id' => 'required',

            'tanggal' => 'required',

            'deskripsi' => 'required',

            'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'

        ]);

        $gambar = $event->gambar;

        if ($request->hasFile('gambar')) {

            if ($gambar) {

                Storage::disk('public')->delete($gambar);

            }

            $gambar = $request
                ->file('gambar')
                ->store('events', 'public');

        }

        $event->update([

            'nama_event' => $request->nama_event,

            'kategori_event_id' => $request->kategori_event_id,

            'lokasi_id' => $request->lokasi_id,

            'tanggal' => $request->tanggal,

            'deskripsi' => $request->deskripsi,

            'gambar' => $gambar

        ]);

        return redirect()
            ->route('events.index')
            ->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        if ($event->gambar) {

            Storage::disk('public')->delete($event->gambar);

        }

        $event->delete();

        return redirect()
            ->route('events.index')
            ->with('success', 'Event berhasil dihapus.');
    }


}
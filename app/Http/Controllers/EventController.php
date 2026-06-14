<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\KategoriEvent;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /*
    |==========================================================================
    | ADMIN: CRUD Event lengkap
    |==========================================================================
    */

    public function index()
    {
        $events = Event::with('kategori', 'lokasi')->get();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        $kategoris = KategoriEvent::all();
        $lokasis   = Lokasi::all();
        return view('events.create', compact('kategoris', 'lokasis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_event' => 'required',
            'deskripsi'  => 'required',
            'tanggal'    => 'required',
            'jam'        => 'required'
        ]);

        if ($request->filled('kategori_id')) {
            $kategori = KategoriEvent::findOrFail($request->kategori_id);
        } else {
            $request->validate(['kategori' => 'required']);
            $kategori = KategoriEvent::create(['nama_kategori' => $request->kategori]);
        }

        if ($request->filled('lokasi_id')) {
            $lokasi = Lokasi::findOrFail($request->lokasi_id);
        } else {
            $request->validate(['lokasi' => 'required', 'alamat' => 'required']);
            $lokasi = Lokasi::create([
                'nama_lokasi' => $request->lokasi,
                'alamat'      => $request->alamat,
                'kapasitas'   => 0
            ]);
        }

        Event::create([
            'kategori_id' => $kategori->id,
            'lokasi_id'   => $lokasi->id,
            'nama_event'  => $request->nama_event,
            'deskripsi'   => $request->deskripsi,
            'tanggal'     => $request->tanggal,
            'jam'         => $request->jam
        ]);

        return redirect()->route('events.index')
            ->with('success', 'Event berhasil ditambahkan');
    }

    public function show($id)
    {
        $event = Event::with(['kategori', 'lokasi', 'tikets'])->findOrFail($id);
        return view('events.show', compact('event'));
    }

    public function edit($id)
    {
        $event     = Event::findOrFail($id);
        $kategoris = KategoriEvent::all();
        $lokasis   = Lokasi::all();
        return view('events.edit', compact('event', 'kategoris', 'lokasis'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'nama_event' => 'required',
            'deskripsi'  => 'required',
            'tanggal'    => 'required',
            'jam'        => 'required'
        ]);

        if ($request->filled('kategori_id')) {
            $kategori = KategoriEvent::findOrFail($request->kategori_id);
        } else {
            $kategori = KategoriEvent::firstOrCreate(['nama_kategori' => $request->kategori]);
        }

        if ($request->filled('lokasi_id')) {
            $lokasi = Lokasi::findOrFail($request->lokasi_id);
        } else {
            $lokasi = Lokasi::firstOrCreate(
                ['nama_lokasi' => $request->lokasi],
                ['alamat' => $request->alamat, 'kapasitas' => 0]
            );
        }

        $event->update([
            'kategori_id' => $kategori->id,
            'lokasi_id'   => $lokasi->id,
            'nama_event'  => $request->nama_event,
            'deskripsi'   => $request->deskripsi,
            'tanggal'     => $request->tanggal,
            'jam'         => $request->jam
        ]);

        return redirect()->route('events.index')
            ->with('success', 'Event berhasil diperbarui');
    }

    public function destroy($id)
    {
        Event::destroy($id);
        return redirect()->route('events.index')
            ->with('success', 'Event berhasil dihapus');
    }

    /*
    |==========================================================================
    | ★ USER: Lihat detail event (read-only) + beli tiket
    |==========================================================================
    */
    public function showUser($id)
    {
        $event = Event::with(['kategori', 'lokasi', 'tikets'])->findOrFail($id);
        return view('user.event-show', compact('event'));
    }
}
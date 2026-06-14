<?php

namespace App\Http\Controllers;

use App\Models\KategoriEvent;
use Illuminate\Http\Request;

class KategoriEventController extends Controller
{
    public function index()
    {
        $kategoris = KategoriEvent::with(
            'events.tikets.transaksis'
        )->get();

        return view(
            'kategori.index',
            compact('kategoris')
        );
    }

    public function create()
    {
        return view(
            'kategori.create'
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required'
        ]);

        KategoriEvent::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()
            ->route('kategori.index')
            ->with(
                'success',
                'Kategori berhasil ditambahkan'
            );
    }

    public function show($id)
    {
        $kategori = KategoriEvent::with(
            'events.tikets.transaksis'
        )->findOrFail($id);

        return view(
            'kategori.show',
            compact('kategori')
        );
    }

    public function edit($id)
    {
        $kategori = KategoriEvent::findOrFail($id);

        return view(
            'kategori.edit',
            compact('kategori')
        );
    }

    public function update(
        Request $request,
        $id
    )
    {
        $request->validate([
            'nama_kategori' => 'required'
        ]);

        $kategori = KategoriEvent::findOrFail($id);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()
            ->route('kategori.index')
            ->with(
                'success',
                'Kategori berhasil diperbarui'
            );
    }

    public function destroy($id)
    {
        $kategori = KategoriEvent::findOrFail($id);

        $kategori->delete();

        return redirect()
            ->route('kategori.index')
            ->with(
                'success',
                'Kategori berhasil dihapus'
            );
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasis = Lokasi::latest()->get();

        return view(
            'lokasi.index',
            compact('lokasis')
        );
    }

    public function create()
    {
        return view('lokasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required',
            'alamat'      => 'required',
            'kapasitas'   => 'required|numeric'
        ]);

        Lokasi::create([
            'nama_lokasi' => $request->nama_lokasi,
            'alamat'      => $request->alamat,
            'kapasitas'   => $request->kapasitas
        ]);

        return redirect()
            ->route('lokasi.index')
            ->with(
                'success',
                'Data lokasi berhasil ditambahkan'
            );
    }

    public function show($id)
    {
        $lokasi = Lokasi::findOrFail($id);

        return view(
            'lokasi.show',
            compact('lokasi')
        );
    }

    public function edit($id)
    {
        $lokasi = Lokasi::findOrFail($id);

        return view(
            'lokasi.edit',
            compact('lokasi')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lokasi' => 'required',
            'alamat'      => 'required',
            'kapasitas'   => 'required|numeric'
        ]);

        $lokasi = Lokasi::findOrFail($id);

        $lokasi->update([
            'nama_lokasi' => $request->nama_lokasi,
            'alamat'      => $request->alamat,
            'kapasitas'   => $request->kapasitas
        ]);

        return redirect()
            ->route('lokasi.index')
            ->with(
                'success',
                'Data lokasi berhasil diperbarui'
            );
    }

    public function destroy($id)
    {
        $lokasi = Lokasi::findOrFail($id);

        $lokasi->delete();

        return redirect()
            ->route('lokasi.index')
            ->with(
                'success',
                'Data lokasi berhasil dihapus'
            );
    }
}
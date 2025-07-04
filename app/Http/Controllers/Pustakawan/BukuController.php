<?php

namespace App\Http\Controllers\Pustakawan;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::with('kategori')->get();
        return view('pustakawan.buku.index', compact('bukus'));
    }

    public function create()
    {
        $kategoris = KategoriBuku::all();
        return view('pustakawan.buku.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_kategori'   => 'required|exists:kategori_bukus,id_kategori',
            'judul_buku'    => 'required|string|max:255',
            'penulis'       => 'required|string|max:255',
            'penerbit'      => 'required|string|max:255',
            'tahun_terbit'  => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'cover'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('covers'), $namaFile); // Simpan file ke folder public/covers
            $data['cover'] = $namaFile; // Hanya simpan nama file ke database
        }

        Buku::create($data);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan');
    }


    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategoris = KategoriBuku::all();
        return view('pustakawan.buku.edit', compact('buku', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul_buku'    => 'required|string|max:255',
            'id_kategori'   => 'required|exists:kategori_bukus,id_kategori',
            'penulis'       => 'required|string|max:255',
            'penerbit'      => 'required|string|max:255',
            'tahun_terbit'  => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'cover'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $buku = Buku::findOrFail($id);

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('covers'), $namaFile);
            $validated['cover'] = $namaFile;
        }

        $buku->update($validated);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diupdate.');
    }


    public function destroy($id)
    {
        Buku::destroy($id);
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus');
    }
}

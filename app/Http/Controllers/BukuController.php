<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        return response()->json(Buku::with('kategori')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_kategori' => 'required|exists:kategori_bukus,id_kategori',
            'judul_buku' => 'required|string|max:255',
            'penulis' => 'required|string',
            'penerbit' => 'required|string',
            'tahun_terbit' => 'required|digits:4',
        ]);

        $buku = Buku::create($validated);
        return response()->json($buku, 201);
    }

    public function show($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);
        return response()->json($buku);
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $validated = $request->validate([
            'id_kategori' => 'sometimes|exists:kategori_bukus,id_kategori',
            'judul_buku' => 'sometimes|string|max:255',
            'penulis' => 'sometimes|string',
            'penerbit' => 'sometimes|string',
            'tahun_terbit' => 'sometimes|digits:4',
        ]);

        $buku->update($validated);
        return response()->json($buku);
    }

    public function destroy($id)
    {
        Buku::destroy($id);
        return response()->json(['message' => 'Buku dihapus']);
    }
}

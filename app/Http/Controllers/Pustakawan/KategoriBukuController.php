<?php

namespace App\Http\Controllers\Pustakawan;

use App\Http\Controllers\Controller;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class KategoriBukuController extends Controller
{
    public function index()
    {
        $kategoris = KategoriBuku::all();
        return view('pustakawan.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('pustakawan.kategori.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kategori' => 'required|unique:kategori_bukus,nama_kategori',
        ]);

        KategoriBuku::create($data);
        return redirect()->route('pustakawan.kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function destroy($id)
    {
        KategoriBuku::destroy($id);
        return redirect()->route('pustakawan.kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}

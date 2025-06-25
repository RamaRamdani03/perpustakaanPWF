<?php

namespace App\Http\Controllers;

use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class KategoriBukuController extends Controller
{
    public function index()
    {
        return KategoriBuku::all();
    }

    public function store(Request $request)
    {
        $request->validate(['nama_kategori' => 'required']);
        return KategoriBuku::create(['nama_kategori' => $request->nama_kategori]);
    }

    public function show($id)
    {
        return KategoriBuku::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $k = KategoriBuku::findOrFail($id);
        $k->update(['nama_kategori' => $request->nama_kategori]);
        return $k;
    }

    public function destroy($id)
    {
        KategoriBuku::destroy($id);
        return ['message' => 'Kategori dihapus'];
    }
}

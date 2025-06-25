<?php

namespace App\Http\Controllers\Pustakawan;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggotas = Anggota::all();
        return view('pustakawan.anggota.index', compact('anggotas'));
    }

    public function create()
    {
        return view('pustakawan.anggota.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_anggota'     => 'required|string|max:255',
            'username'         => 'required|string|max:255|unique:anggotas,username',
            'password'         => 'required|string|min:6',
            'no_tlp_anggota'   => 'required|string|max:15',
            'alamat_anggota'   => 'required|string',
        ]);

        $validated['id_pustakawan'] = auth()->user()->id_pustakawan; // Ambil dari pustakawan yang login
        $validated['password'] = Hash::make($validated['password']);

        Anggota::create($validated);

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('pustakawan.anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);

        $validated = $request->validate([
            'nama_anggota'     => 'required|string|max:255',
            'username'         => 'required|string|max:255|unique:anggotas,username,' . $id . ',id_anggota',
            'password'         => 'nullable|string|min:6',
            'no_tlp_anggota'   => 'required|string|max:15',
            'alamat_anggota'   => 'required|string',
        ]);

        if ($validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']); // Jangan update password jika kosong
        }

        $anggota->update($validated);

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Anggota::destroy($id);
        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil dihapus.');
    }
}

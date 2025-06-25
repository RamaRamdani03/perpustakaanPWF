<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function index()
    {
        return Anggota::with('pustakawan')->get();
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'id_pustakawan' => 'required|exists:pustakawans,id_pustakawan',
            'nama_anggota' => 'required',
            'usr_anggota' => 'required|unique:anggotas',
            'pw_anggota' => 'required',
            'no_tlp_anggota' => 'required',
            'alamat_anggota' => 'required',
        ]);
        $data['pw_anggota'] = Hash::make($data['pw_anggota']);
        return Anggota::create($data);
    }

    public function show($id)
    {
        return Anggota::with('pustakawan')->findOrFail($id);
    }

    public function update(Request $r, $id)
    {
        $a = Anggota::findOrFail($id);
        $a->update([
            'nama_anggota' => $r->nama_anggota,
            'pw_anggota' => Hash::make($r->pw_anggota),
            'no_tlp_anggota' => $r->no_tlp_anggota,
            'alamat_anggota' => $r->alamat_anggota,
        ]);
        return $a;
    }

    public function destroy($id)
    {
        Anggota::destroy($id);
        return ['message' => 'Anggota deleted'];
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pustakawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PustakawanController extends Controller
{
    public function index()
    {
        $pustakawans = Pustakawan::all();
        return view('admin.pustakawan.index', compact('pustakawans'));
    }

    public function create()
    {
        return view('admin.pustakawan.create');
    }

    public function edit($id)
    {
        $pustakawan = Pustakawan::findOrFail($id);
        return view('admin.pustakawan.edit', compact('pustakawan'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_pustaka' => 'required',
            'username' => 'required|unique:pustakawans',
            'password' => 'required',
            'no_tlp_pustaka' => 'required',
            'alamat_pustaka' => 'required',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['id_admin'] = auth()->user()->id_admin;

        Pustakawan::create($data);
        return redirect()->route('pustakawan.index')->with('success', 'Pustakawan ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $p = Pustakawan::findOrFail($id);

        $data = $request->validate([
            'nama_pustaka' => 'required',
            'username' => 'required|unique:pustakawans,username,' . $id . ',id_pustakawan',
            'password' => 'nullable',
            'no_tlp_pustaka' => 'required',
            'alamat_pustaka' => 'required',
        ]);

        // Jika password diisi, hash dan update, jika tidak jangan update password
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);  // hapus supaya tidak update password jadi null
        }

        $p->update($data);

        return redirect()->route('pustakawan.index')->with('success', 'Data pustakawan berhasil diperbarui');
    }


    public function destroy($id)
    {
        Pustakawan::destroy($id);
        return redirect()->route('pustakawan.index')->with('success', 'Pustakawan dihapus');
    }
}

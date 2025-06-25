<?php

namespace App\Http\Controllers;

use App\Models\Pustakawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PustakawanController extends Controller
{
    public function index()
    {
        return Pustakawan::with('admin')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_admin' => 'required|exists:admins,id_admin',
            'nama_pustaka' => 'required',
            'username' => 'required|unique:pustakawans',
            'password' => 'required',
            'no_tlp_pustaka' => 'required',
            'alamat_pustaka' => 'required',
        ]);
        $data['pw_pustaka'] = Hash::make($data['pw_pustaka']);
        return Pustakawan::create($data);
    }

    public function show($id)
    {
        return Pustakawan::with('admin')->findOrFail($id);
    }

    public function edit($id)
    {
        $pustakawan = Pustakawan::findOrFail($id);
        return view('admin.pustakawan.edit', compact('pustakawan'));
    }

    public function update(Request $request, $id)
    {
        $p = Pustakawan::findOrFail($id);
        $p->update([
            'nama_pustaka' => $request->nama_pustaka,
            'password' => Hash::make($request->password),
            'no_tlp_pustaka' => $request->no_tlp_pustaka,
            'alamat_pustaka' => $request->alamat_pustaka,
        ]);
        return $p;
    }

    public function destroy($id)
    {
        Pustakawan::destroy($id);
        return ['message' => 'Pustakawan deleted'];
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    // Menampilkan daftar pelanggan
    public function index()
    {
        $models = Pelanggan::where('status', '!=', -1)->get();
        return view('admin.pelanggan.index', compact('models'));
    }

    // Menyimpan data pelanggan
    public function store(Request $request)
    {
        $data = new Pelanggan();
        $data->nama = $request->nama;
        $data->alamat = $request->alamat;
        $data->email = $request->email;
        $data->no_telepon = $request->no_telepon;
        $data->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil tambah data');
    }

    // Update data pelanggan
    public function update(Request $request, $id)
    {
        $data = Pelanggan::find($id);
        $data->nama = $request->nama;
        $data->alamat = $request->alamat;
        $data->email = $request->email;
        $data->no_telepon = $request->no_telepon;
        $data->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil ubah data');
    }

    // Hapus data pelanggan
    public function destroy($id)
    {
        $data = Pelanggan::findOrFail($id);
        $data->status = -1;
        $data->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil hapus data');
    }
}

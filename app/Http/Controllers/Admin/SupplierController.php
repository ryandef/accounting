<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // Menampilkan daftar supplier
    public function index()
    {
        $models = Supplier::where('status', '!=', -1)->get();
        return view('admin.supplier.index', compact('models'));
    }

    // Menyimpan data supplier
    public function store(Request $request)
    {
        $data = new Supplier();
        $data->nama = $request->nama;
        $data->alamat = $request->alamat;
        $data->email = $request->email;
        $data->no_telepon = $request->no_telepon;
        $data->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil tambah data');
    }

    // Update data supplier
    public function update(Request $request, $id)
    {
        $data = Supplier::find($id);
        $data->nama = $request->nama;
        $data->alamat = $request->alamat;
        $data->email = $request->email;
        $data->no_telepon = $request->no_telepon;
        $data->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil ubah data');
    }

    // Hapus data supplier
    public function destroy($id)
    {
        $data = Supplier::findOrFail($id);
        $data->status = -1;
        $data->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil hapus data');
    }
}

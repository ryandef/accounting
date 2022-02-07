<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Akun;
use Illuminate\Http\Request;

class AkunController extends Controller
{
    // Menampilkan daftar akun
    public function index()
    {
        $models = Akun::where('status', '!=', -1)->orderBy('no_reff')->get();
        $parent = Akun::where('status', '!=', -1)->where('parent_id', null)->orderBy('no_reff')->get();
        return view('admin.akun.index', compact('models', 'parent'));
    }

    // Menyimpan data akun
    public function store(Request $request)
    {
        $data = new Akun();
        $data->no_reff = $request->no_reff;
        $data->nama_reff = $request->nama_reff;
        $data->parent_id = $request->parent_id;
        $data->keterangan = $request->keterangan;
        $data->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil tambah data');
    }

    // Update data akun
    public function update(Request $request, $id)
    {
        $data = Akun::find($id);
        $data->no_reff = $request->no_reff;
        $data->nama_reff = $request->nama_reff;
        $data->keterangan = $request->keterangan;
        $data->parent_id = $request->parent_id;
        $data->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil ubah data');
    }

    // Hapus data akun
    public function destroy($id)
    {
        $data = Akun::findOrFail($id);
        $data->status = -1;
        $data->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil hapus data');
    }
}

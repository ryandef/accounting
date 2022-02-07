<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Transaksi;
use App\Akun;
use App\Jurnal;
use Auth;

class JurnalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $models = Jurnal::orderBy('tanggal', 'desc');
        if ($request->start) {
            $models->whereDate('tanggal', '>=', $request->start);
        }

        if ($request->end) {
            $models->whereDate('tanggal', '<=', $request->end);
        }

        if ($request->no_jurnal) {
            $models->where('no_jurnal', $request->no_jurnal);
        }
        $models = $models->paginate(10);
        return view('admin.jurnal-umum.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id_biaya = Akun::select('id')->where(function ($query) {
            $query->where('id', 11)
                ->orWhere('parent_id', 11);
        })->get();

        $akun = Akun::where('status', 1)->where(function($query) use ($id_biaya){
            $query->where('id', '!=', 9);
            $query->where('id', '!=', 10);
            $query->whereNotIn('id', $id_biaya);
        })->orderBy('no_reff')->get();
        $kas = Transaksi::jumlahKas();
        return view('admin.jurnal-umum.create', compact('akun', 'kas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // SIMPAN DI JURNAL
        $jurnal = new Jurnal;
        $jurnal->catatan = $request->catatan;
        $jurnal->tanggal = $request->tanggal;
        $jurnal->save();

        $debit = new Transaksi;
        $debit->jurnal_id = $jurnal->id;
        $debit->user_id = Auth::user()->id;
        $debit->akun_id = $request->akun_id[0];
        $debit->tanggal = $request->tanggal;
        $debit->jenis_saldo = $request->jenis_saldo[0];
        $debit->saldo = $request->saldo;
        $debit->save();

        $kredit = new Transaksi;
        $kredit->jurnal_id = $jurnal->id;
        $kredit->user_id = Auth::user()->id;
        $kredit->akun_id = $request->akun_id[1];
        $kredit->tanggal = $request->tanggal;
        $kredit->jenis_saldo = $request->jenis_saldo[1];
        $kredit->saldo = $request->saldo;
        $kredit->reff_id = $debit->id;
        $kredit->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil tambah data');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id_biaya = Akun::select('id')->where(function ($query) {
            $query->where('id', 11)
                ->orWhere('parent_id', 11);
        })->get();

        $akun = Akun::where('status', 1)->where(function($query) use ($id_biaya){
            $query->where('id', '!=', 9);
            $query->where('id', '!=', 10);
            $query->whereNotIn('id', $id_biaya);
        })->orderBy('no_reff')->get();
        $model = Jurnal::findOrFail($id);
        return view('admin.jurnal-umum.edit', compact('akun', 'model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $model = Jurnal::findOrFail($id);
        $model->tanggal = $request->tanggal;
        $model->catatan = $request->catatan;
        $model->save();

        foreach ($model->transaksi as $key => $item) {
            $item->akun_id = $request->akun_id[$key];
            $item->saldo = $request->saldo;
            $item->save();
        }

        return redirect()
            ->route('admin.jurnal-umum.index')
            ->with('success', 'Berhasil update data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

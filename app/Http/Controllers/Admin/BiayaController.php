<?php

namespace App\Http\Controllers\Admin;

use App\Akun;
use App\Http\Controllers\Controller;
use App\Transaksi;
use App\Jurnal;
use Auth;
use Illuminate\Http\Request;

class BiayaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $biaya = Akun::select('id')->where('parent_id', 11)->get();

        $models = Transaksi::where('status', 1)->where(function($query) use ($biaya) {
            $query->where('akun_id', 11)
                ->orWhereIn('akun_id', $biaya);
        })->orderBy('id', 'asc');

        if ($request->start) {
            $models->whereDate('tanggal', '>=', $request->start);
        }

        if ($request->end) {
            $models->whereDate('tanggal', '<=', $request->end);
        }

        $models = $models->get();


        return view('admin.biaya.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $akun = Akun::where('parent_id', 11)->where('status', 1)->get();
        $kas = Transaksi::jumlahKas();
        return view('admin.biaya.create', compact('akun', 'kas'));
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

        // SALDO DEBET
        $debit = new Transaksi;
        $debit->user_id = Auth::user()->id;
        $debit->akun_id = $request->akun_id;
        $debit->jurnal_id = $jurnal->id;
        $debit->tanggal = $request->tanggal;
        $debit->jenis_saldo = 1;
        $debit->saldo = $request->saldo;
        $debit->save();

        // SALDO KREDIT
        $kredit = new Transaksi;
        $kredit->jurnal_id = $jurnal->id;
        $kredit->user_id = Auth::user()->id;
        $kredit->akun_id = 1;
        $kredit->tanggal = $request->tanggal;
        $kredit->jenis_saldo = 2;
        $kredit->saldo = $request->saldo;
        $kredit->reff_id = $debit->id;
        $kredit->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil tambah biaya');
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
        $model = Transaksi::findOrFail($id);
        $akun = Akun::where('parent_id', 11)->where('status', 1)->get();
        return view('admin.biaya.edit', compact('akun', 'model'));
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
        $model = Transaksi::findOrFail($id);
        $jurnal = $model->jurnal;
        $jurnal->catatan = $request->catatan;
        $jurnal->tanggal = $request->tanggal;
        $jurnal->save();

        foreach ($jurnal->transaksi as $transaksi) {
            if($transaksi->jenis_saldo == 1) {
                $transaksi->akun_id = $request->akun_id;
            }
            $transaksi->tanggal = $request->tanggal;
            $transaksi->saldo = $request->saldo;
            $transaksi->save();
        }

        return redirect()
            ->back()
            ->with('success', 'Berhasil edit biaya');
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jurnal;
use App\Pelanggan;
use App\Transaksi;
use App\TransaksiPenjualan;
use Auth;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $models = TransaksiPenjualan::where('status', '!=', -1)->orderBy('tanggal');

        if ($request->start) {
            $models->whereDate('tanggal', '>=', $request->start);
        }

        if ($request->end) {
            $models->whereDate('tanggal', '<=', $request->end);
        }

        $models = $models->get();

        return view('admin.penjualan.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pelanggan = Pelanggan::where('status', 1)->get();
        return view('admin.penjualan.create', compact('pelanggan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pelanggan = Pelanggan::find($request->pelanggan_id);

        // SIMPAN DI JURNAL
        $jurnal = new Jurnal;
        if ($request->type == 1) {
            $jurnal->catatan = 'Penjualan tunai ke ' . $pelanggan->nama;
        } else {
            $jurnal->catatan = 'Penjualan kredit ke ' . $pelanggan->nama;
        }
        $jurnal->tanggal = $request->tanggal;
        $jurnal->save();

        if ($request->type == 1) {
            // SALDO DEBIT
            $debit = new Transaksi;
            $debit->user_id = Auth::user()->id;
            $debit->akun_id = 1;
            $debit->jurnal_id = $jurnal->id;
            $debit->tanggal = $request->tanggal;
            $debit->jenis_saldo = 1;
            $debit->saldo = $request->saldo;
            $debit->save();
        } else {
            // SALDO DEBIT
            $debit = new Transaksi;
            $debit->user_id = Auth::user()->id;
            $debit->akun_id = 2;
            $debit->jurnal_id = $jurnal->id;
            $debit->tanggal = $request->tanggal;
            $debit->jenis_saldo = 1;
            $debit->saldo = $request->saldo;
            $debit->save();
        }

        // SALDO KREDIT
        $kredit = new Transaksi;
        $kredit->user_id = Auth::user()->id;
        $kredit->akun_id = 9;
        $kredit->jurnal_id = $jurnal->id;
        $kredit->tanggal = $request->tanggal;
        $kredit->jenis_saldo = 2;
        $kredit->saldo = $request->saldo;
        $kredit->reff_id = $debit->id;
        $kredit->save();

        $penjualan = new TransaksiPenjualan();
        $penjualan->pelanggan_id = $request->pelanggan_id;
        $penjualan->jurnal_id = $jurnal->id;
        $penjualan->tanggal = $request->tanggal;
        $penjualan->status = $request->type;
        $penjualan->tipe = $request->type;
        $penjualan->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil tambah penjualan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = TransaksiPenjualan::find($id);
        return view('admin.penjualan.show', compact('model'));
    }

    public function edit($id)
    {
        $model = TransaksiPenjualan::find($id);
        $pelanggan = Pelanggan::where('status', 1)->get();
        return view('admin.penjualan.edit', compact('model', 'pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $penjualan = TransaksiPenjualan::find($id);
        $penjualan->pelanggan_id = $request->pelanggan_id;
        $penjualan->tanggal = $request->tanggal;
        $penjualan->save();

        $jurnal = $penjualan->jurnal;
        if ($penjualan->tipe == 1) {
            $jurnal->catatan = 'Penjualan tunai ke ' . $penjualan->pelanggan->nama;
        } else {
            $jurnal->catatan = 'Penjualan kredit ke ' . $penjualan->pelanggan->nama;
        }
        $jurnal->tanggal = $request->tanggal;
        $jurnal->save();

        foreach ($jurnal->transaksi as $transaksi) {
            $transaksi->tanggal = $request->tanggal;
            $transaksi->saldo = $request->saldo;
            $transaksi->save();
        }

        foreach ($jurnal->jurnal as $child) {
            $child->catatan = 'Pelunasan dari ' . $penjualan->pelanggan->nama;
            $child->save();
            foreach ($child->transaksi as $transaksi) {
                $transaksi->saldo = $request->saldo;
                $transaksi->save();
            }
        }


        return redirect()
            ->back()
            ->with('success', 'Berhasil edit penjualan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function lunas($id)
    {
        $old = TransaksiPenjualan::find($id);
        $pelanggan = $old->pelanggan;

        $old->status = 1;
        $old->save();

        // SIMPAN DI JURNAL
        $jurnal = new Jurnal;
        $jurnal->catatan = 'Pelunasan dari ' . $pelanggan->nama;
        $jurnal->tanggal = date('Y-m-d');
        $jurnal->parent_id = $old->jurnal->id;
        $jurnal->save();

        $debit = new Transaksi;
        $debit->user_id = Auth::user()->id;
        $debit->akun_id = 1;
        $debit->jurnal_id = $jurnal->id;
        $debit->tanggal = date('Y-m-d');
        $debit->jenis_saldo = 1;
        $debit->saldo = $old->jurnal->satuTransaksi->saldo;
        $debit->save();

        $kredit = new Transaksi;
        $kredit->user_id = Auth::user()->id;
        $kredit->akun_id = 2;
        $kredit->jurnal_id = $jurnal->id;
        $kredit->tanggal = date('Y-m-d');
        $kredit->jenis_saldo = 2;
        $kredit->saldo = $old->jurnal->satuTransaksi->saldo;
        $kredit->reff_id = $debit->id;
        $kredit->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil lunasi penjualan kredit');
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

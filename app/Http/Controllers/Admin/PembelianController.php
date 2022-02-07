<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Transaksi;
use App\Supplier;
use App\TransaksiPembelian;
use App\Jurnal;
use Auth;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $models = TransaksiPembelian::where('status', '!=', -1)->orderBy('tanggal');

        if ($request->start) {
            $models->whereDate('tanggal', '>=', $request->start);
        }

        if ($request->end) {
            $models->whereDate('tanggal', '<=', $request->end);
        }

        $models = $models->get();

        return view('admin.pembelian.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplier = Supplier::where('status', 1)->get();
        $kas = Transaksi::jumlahKas();
        return view('admin.pembelian.create', compact('supplier', 'kas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $supplier = Supplier::find($request->supplier_id);

        // SIMPAN DI JURNAL
        $jurnal = new Jurnal;
        if($request->type == 1) {
            $jurnal->catatan = 'Pembelian tunai ke '.$supplier->nama;
        } else {
            $jurnal->catatan = 'Pembelian kredit ke '.$supplier->nama;
        }
        $jurnal->tanggal = $request->tanggal;
        $jurnal->save();

        // SALDO DEBET
        $debit = new Transaksi;
        $debit->user_id = Auth::user()->id;
        $debit->akun_id = 10;
        $debit->jurnal_id = $jurnal->id;
        $debit->tanggal = $request->tanggal;
        $debit->jenis_saldo = 1;
        $debit->saldo = $request->saldo;
        $debit->save();

        // SALDO KREDIT
        $kredit = new Transaksi;
        $kredit->jurnal_id = $jurnal->id;
        $kredit->user_id = Auth::user()->id;
        $kredit->tanggal = $request->tanggal;
        $kredit->saldo = $request->saldo;
        $kredit->reff_id = $debit->id;
        if($request->type == 1) {
            $kredit->akun_id = 1;
            $kredit->jenis_saldo = 2;
        } else {
            $kredit->akun_id = 6;
            $kredit->jenis_saldo = 2;
        }
        $kredit->save();

        $pembelian = new TransaksiPembelian();
        $pembelian->jurnal_id = $jurnal->id;
        $pembelian->tanggal = $request->tanggal;
        $pembelian->tipe = $request->type;
        $pembelian->supplier_id = $request->supplier_id;
        $pembelian->status = $request->type;
        $pembelian->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil tambah pembelian');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = TransaksiPembelian::find($id);
        return view('admin.pembelian.show', compact('model'));
    }

    public function edit($id)
    {
        $model = TransaksiPembelian::find($id);
        $supplier = Supplier::where('status', 1)->get();
        return view('admin.pembelian.edit', compact('model', 'supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function lunas($id)
    {
        $old = TransaksiPembelian::find($id);
        $supplier = $old->supplier;

        $old->status = 1;
        $old->save();

        // SIMPAN DI JURNAL
        $jurnal = new Jurnal;
        $jurnal->catatan = 'Pelunasan ke ' . $supplier->nama;
        $jurnal->tanggal = date('Y-m-d');
        $jurnal->parent_id = $old->jurnal->id;
        $jurnal->save();

        $debit = new Transaksi;
        $debit->user_id = Auth::user()->id;
        $debit->akun_id = 6;
        $debit->jurnal_id = $jurnal->id;
        $debit->tanggal = date('Y-m-d');
        $debit->jenis_saldo = 1;
        $debit->saldo = $old->jurnal->satuTransaksi->saldo;
        $debit->save();

        $kredit = new Transaksi;
        $kredit->user_id = Auth::user()->id;
        $kredit->akun_id = 1;
        $kredit->jurnal_id = $jurnal->id;
        $kredit->tanggal = date('Y-m-d');
        $kredit->jenis_saldo = 2;
        $kredit->saldo = $old->jurnal->satuTransaksi->saldo;
        $kredit->reff_id = $debit->id;
        $kredit->save();

        return redirect()
            ->back()
            ->with('success', 'Berhasil lunasi pembelian kredit');
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
        $pembelian = TransaksiPembelian::find($id);
        $pembelian->supplier_id = $request->supplier_id;
        $pembelian->tanggal = $request->tanggal;
        $pembelian->save();

        $jurnal = $pembelian->jurnal;
        if ($pembelian->tipe == 1) {
            $jurnal->catatan = 'Pembelian tunai ke ' . $pembelian->supplier->nama;
        } else {
            $jurnal->catatan = 'Pembelian kredit ke ' . $pembelian->supplier->nama;
        }
        $jurnal->tanggal = $request->tanggal;
        $jurnal->save();

        foreach ($jurnal->transaksi as $transaksi) {
            $transaksi->tanggal = $request->tanggal;
            $transaksi->saldo = $request->saldo;
            $transaksi->save();
        }

        foreach ($jurnal->jurnal as $child) {
            $child->catatan = 'Pelunasan ke ' . $pembelian->supplier->nama;
            $child->save();
            foreach ($child->transaksi as $transaksi) {
                $transaksi->saldo = $request->saldo;
                $transaksi->save();
            }
        }

        return redirect()
            ->back()
            ->with('success', 'Berhasil edit pembelian');
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

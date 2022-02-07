<?php

namespace App\Http\Controllers\Admin;

use App\Akun;
use App\Http\Controllers\Controller;
use App\Transaksi;
use App\TransaksiPenjualan;
use App\TransaksiPembelian;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sdate = DATE('Y-m-d', strtotime(DATE('Y-m-d') . "-7 day"));
        for ($i = 0; $i < 8; $i++) {
            $ndate = DATE('Y-m-d', strtotime($sdate . "+" . $i . " day"));
            $sidate = DATE('d-m-Y', strtotime($sdate . "+" . $i . " day"));
            $date_graph[] = $sidate;
            // $check_graph[] = TransaksiPenjualan::whereDate('tanggal', $ndate)
            //     ->count();

            $check_graph[] = Transaksi::whereDate('tanggal', $ndate)
                ->where('jenis_saldo', 1)
                ->whereHas('jurnal', function($query) {
                    $query->has('penjualan');
                })
                ->sum('saldo');

            $id_penjualan = Akun::select('id')->where('parent_id', 9)->get();
            $pendapatan = Transaksi::where('status', 1)->where(function ($query) use ($id_penjualan) {
                    $query->where('akun_id', 9)
                        ->orWhereIn('akun_id', $id_penjualan);
            })->whereDate('tanggal', $ndate)->sum('saldo');

            $id_pengeluaran = Akun::select('id')->where('parent_id', 10)->get();
            $id_biaya = Akun::select('id')->where(function ($query) {
                $query->where('id', 11)
                    ->orWhere('parent_id', 11);
            })->get();

            $pengeluaran = Transaksi::where('status', 1)->where(function ($query) use ($id_pengeluaran, $id_biaya) {
                $query->where('akun_id', 10)
                    ->orWhereIn('akun_id', $id_pengeluaran)
                    ->orWhereIn('akun_id', $id_biaya);
            })->whereDate('tanggal', $ndate)->sum('saldo');

            $date_laba_graph[] = $sidate;
            $check_laba_graph[] = $pendapatan - $pengeluaran;
        }


        $id_biaya = Akun::where(function ($query) {
            $query->where('id', 11)
                ->orWhere('parent_id', 11);
        })->get();

        foreach ($id_biaya as $id) {

            $b = Transaksi::where('status', 1)->where('akun_id', $id->id)->sum('saldo');

            if($b > 0) {
                $biaya_graph[] = $b;
                $biaya_label_graph[] = $id->nama_reff;
            }

        }

        $data['biaya_label_graph'] = json_encode($biaya_label_graph);
        $data['biaya_graph'] = json_encode($biaya_graph);

        $data['check_graph'] = json_encode($check_graph);
        $data['date_graph'] = json_encode($date_graph);
        $data['check_laba_graph'] = json_encode($check_laba_graph);
        $data['date_laba_graph'] = json_encode($date_laba_graph);

        $data['penjualan'] = 0;
        $data['biaya'] = 0;

        $penjualan = TransaksiPenjualan::whereDate('tanggal', date('Y-m-d'))->get();

        foreach ($penjualan as $jualan) {
            $data['penjualan'] += $jualan->jurnal->satuTransaksi->saldo;
        }

        $biaya = Akun::select('id')->where('parent_id', 11)->get();

        $data['biaya'] = Transaksi::where('status', 1)
            ->whereDate('tanggal', date('Y-m-d'))
            ->where(function ($query) use ($biaya) {
                $query->where('akun_id', 11)
                    ->orWhereIn('akun_id', $biaya);
            })->orderBy('id', 'asc')->sum('saldo');

        $data['list_pembelian'] = TransaksiPembelian::orderBy('tanggal', 'desc')->get()->take(5);
        $data['list_penjualan'] = TransaksiPenjualan::orderBy('tanggal', 'desc')->get()->take(5);
        $data['penjualan_lunas'] = Transaksi::where('jenis_saldo', 1)->whereHas('jurnal', function($query){
            $query->whereHas('penjualan', function($q){
                $q->where('status', 1);
            });
        })->sum('saldo');

        $data['penjualan_piutang'] = Transaksi::where('jenis_saldo', 1)->whereHas('jurnal', function($query){
            $query->whereHas('penjualan', function($q){
                $q->where('status', 0);
            });
        })->sum('saldo');

        $data['pembelian_lunas'] = Transaksi::where('jenis_saldo', 1)->whereHas('jurnal', function($query){
            $query->whereHas('pembelian', function($q){
                $q->where('status', 1);
            });
        })->sum('saldo');

        $data['pembelian_utang'] = Transaksi::where('jenis_saldo', 1)->whereHas('jurnal', function($query){
            $query->whereHas('pembelian', function($q){
                $q->where('status', 0);
            });
        })->sum('saldo');

        return view('admin.dashboard.accounting', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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

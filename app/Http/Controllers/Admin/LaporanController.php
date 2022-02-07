<?php

namespace App\Http\Controllers\Admin;

use App\Akun;
use App\Http\Controllers\Controller;
use App\Jurnal;
use App\Transaksi;
use DB;
use Illuminate\Http\Request;
use PDF;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function jurnalUmum(Request $request)
    {
        $models = Jurnal::orderBy('tanggal', 'asc');

        if ($request->start) {
            $models->whereDate('tanggal', '>=', $request->start);
        }

        if ($request->end) {
            $models->whereDate('tanggal', '<=', $request->end);
        }

        $models = $models->get();

        $deskripsi = "";
        if ($request->start) {
            $deskripsi = date('d M Y', strtotime($request->start));
        }

        if ($request->end) {
            if ($request->end != $request->start) {
                $deskripsi = $deskripsi . ' - ' . date('d M Y', strtotime($request->end));
            }
        } else if ($request->start) {
            $deskripsi = $deskripsi . ' - sekarang';
        }

        if ($request->submit == 'pdf') {
            $pdf = PDF::loadview('admin.laporan.jurnal-umum.pdf', ['models' => $models, 'deskripsi' => $deskripsi])->setPaper('a4', 'landscape')->setWarnings(false);;
            return $pdf->download('laporan-jurnal-umum_' . date('d_m_Y_H_i_s') . '.pdf');
        }
        return view('admin.laporan.jurnal-umum.index', compact('models', 'deskripsi'));
    }

    public function bukuBesar(Request $request)
    {
        $models = DB::table('transaksis')->select('transaksis.*', 'akuns.nama_reff', 'jurnals.catatan')
            ->where('transaksis.status', 1)
            ->join('akuns', 'transaksis.akun_id', '=', 'akuns.id')
            ->join('jurnals', 'transaksis.jurnal_id', '=', 'jurnals.id');

        if ($request->start) {
            $models->whereDate('transaksis.tanggal', '>=', $request->start);
        }

        if ($request->end) {
            $models->whereDate('transaksis.tanggal', '<=', $request->end);
        }

        $models = $models->get()->groupBy('nama_reff');

        $deskripsi = "";
        if ($request->start) {
            $deskripsi = date('d M Y', strtotime($request->start));
        }

        if ($request->end) {
            if ($request->end != $request->start) {
                $deskripsi = $deskripsi . ' - ' . date('d M Y', strtotime($request->end));
            }
        } else if ($request->start) {
            $deskripsi = $deskripsi . ' - sekarang';
        }
        if ($request->submit == 'pdf') {
            $pdf = PDF::loadview('admin.laporan.buku-besar.pdf', ['models' => $models, 'deskripsi' => $deskripsi]);
            return $pdf->download('laporan-buku-besar_' . date('d_m_Y_H_i_s') . '.pdf');
        }
        return view('admin.laporan.buku-besar.index', compact('models', 'deskripsi'));
    }

    public function neracaSaldo(Request $request)
    {
        $models = Akun::where('status', 1)->orderBy('no_reff')->get();

        $deskripsi = "";
        if ($request->start) {
            $deskripsi = date('d M Y', strtotime($request->start));
        }

        if ($request->end) {
            if ($request->end != $request->start) {
                $deskripsi = $deskripsi . ' - ' . date('d M Y', strtotime($request->end));
            }
        } else if ($request->start) {
            $deskripsi = $deskripsi . ' - sekarang';
        }

        if ($request->submit == 'pdf') {
            $pdf = PDF::loadview('admin.laporan.neraca-saldo.pdf', ['models' => $models, 'deskripsi' => $deskripsi]);
            return $pdf->download('laporan-neraca-saldo_' . date('d_m_Y_H_i_s') . '.pdf');
        }

        return view('admin.laporan.neraca-saldo.index', compact('models', 'deskripsi'));
    }

    public function labaRugi(Request $request)
    {
        $id_penjualan = Akun::select('id')->where('parent_id', 9)->get();
        $pendapatan = Transaksi::where('status', 1)->where('akun_id', 1)->where('jenis_saldo', 1);

        if ($request->start) {
            $pendapatan->whereDate('tanggal', '>=', $request->start);
        }

        if ($request->end) {
            $pendapatan->whereDate('tanggal', '<=', $request->end);
        }
        $pendapatan = $pendapatan->get()->groupBy('akun_id');

        $id_pengeluaran = Akun::select('id')->where('parent_id', 10)->get();
        $id_biaya = Akun::select('id')->where(function ($query) {
            $query->where('id', 11)
                ->orWhere('parent_id', 11);
        })->get();

        $pengeluaran = Transaksi::where('status', 1)->where(function ($query) use ($id_pengeluaran, $id_biaya) {
            $query->where('akun_id', 10)
                ->orWhereIn('akun_id', $id_pengeluaran);
                // ->orWhereIn('akun_id', $id_biaya);
        });

        if ($request->start) {
            $pengeluaran->whereDate('tanggal', '>=', $request->start);
        }

        if ($request->end) {
            $pengeluaran->whereDate('tanggal', '<=', $request->end);
        }
        $pengeluaran = $pengeluaran->get()->groupBy('akun_id');


        $biaya = Transaksi::where('status', 1)->where(function ($query) use ($id_pengeluaran, $id_biaya) {
            $query->whereIn('akun_id', $id_biaya);
        });

        if ($request->start) {
            $biaya->whereDate('tanggal', '>=', $request->start);
        }

        if ($request->end) {
            $biaya->whereDate('tanggal', '<=', $request->end);
        }
        $biaya = $biaya->get()->groupBy('akun_id');

        // return $biaya;

        $deskripsi = "";
        if ($request->start) {
            $deskripsi = date('d M Y', strtotime($request->start));
        }

        if ($request->end) {
            if ($request->end != $request->start) {
                $deskripsi = $deskripsi . ' - ' . date('d M Y', strtotime($request->end));
            }
        } else if ($request->start) {
            $deskripsi = $deskripsi . ' - sekarang';
        }

        if ($request->submit == 'pdf') {
            $pdf = PDF::loadview('admin.laporan.laba-rugi.pdf', ['pendapatan' => $pendapatan, 'pengeluaran' => $pengeluaran, 'deskripsi' => $deskripsi, 'biaya' => $biaya]);
            return $pdf->download('laporan-laba-rugi_' . date('d_m_Y_H_i_s') . '.pdf');
        }

        return view('admin.laporan.laba-rugi.index', compact('pendapatan', 'pengeluaran', 'deskripsi', 'biaya'));
    }

    public function arusKas(Request $request)
    {
        $id_penjualan = Akun::select('id')->where('parent_id', 9)->get();
        $id_biaya = Akun::select('id')->where('parent_id', 11)->get();
        $id_pengeluaran = Akun::select('id')->where('parent_id', 10)->get();

        $pendapatan = Transaksi::where('status', 1)->where('akun_id', 1)->where('jenis_saldo', 1);

        if ($request->start) {
            $pendapatan->whereDate('tanggal', '>=', $request->start);
        }

        if ($request->end) {
            $pendapatan->whereDate('tanggal', '<=', $request->end);
        }
        $pendapatan = $pendapatan->sum('saldo');

        $pengeluaran = Transaksi::where('status', 1)->where(function ($query) use ($id_pengeluaran) {
            $query->where('akun_id', 10)
                ->orWhereIn('akun_id', $id_pengeluaran);
        });

        if ($request->start) {
            $pengeluaran->whereDate('tanggal', '>=', $request->start);
        }

        if ($request->end) {
            $pengeluaran->whereDate('tanggal', '<=', $request->end);
        }
        $pengeluaran = $pengeluaran->sum('saldo');

        $biaya = Transaksi::where('status', 1)->where(function ($query) use ($id_biaya) {
            $query->where('akun_id', 11)
                ->orWhereIn('akun_id', $id_biaya);
        });

        if ($request->start) {
            $biaya->whereDate('tanggal', '>=', $request->start);
        }

        if ($request->end) {
            $biaya->whereDate('tanggal', '<=', $request->end);
        }
        $biaya = $biaya->sum('saldo');

        $deskripsi = "";
        if ($request->start) {
            $deskripsi = date('d M Y', strtotime($request->start));
        }

        if ($request->end) {
            if ($request->end != $request->start) {
                $deskripsi = $deskripsi . ' - ' . date('d M Y', strtotime($request->end));
            }
        } else if ($request->start) {
            $deskripsi = $deskripsi . ' - sekarang';
        }

        if ($request->submit == 'pdf') {
            $pdf = PDF::loadview('admin.laporan.arus-kas.pdf', ['biaya' => $biaya, 'pengeluaran' => $pengeluaran, 'pendapatan' => $pendapatan, 'deskripsi' => $deskripsi]);
            return $pdf->download('laporan-arus-kas_' . date('d_m_Y_H_i_s') . '.pdf');
        }

        return view('admin.laporan.arus-kas.index', compact('pendapatan', 'biaya', 'deskripsi', 'pengeluaran'));
    }

}

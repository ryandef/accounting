<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Akun;

class Transaksi extends Model
{
    public static function jumlahKas() {
        $id_pengeluaran = Akun::select('id')->where('parent_id', 10)->get();
        $id_biaya = Akun::select('id')->where(function ($query) {
            $query->where('id', 11)
                ->orWhere('parent_id', 11);
        })->get();

        $pengeluaran = Transaksi::where('status', 1)->where(function ($query) use ($id_pengeluaran, $id_biaya) {
            $query->where('akun_id', 10)
                ->orWhereIn('akun_id', $id_pengeluaran);
        })->sum('saldo');
        $biaya = Transaksi::where('status', 1)->where(function ($query) use ($id_pengeluaran, $id_biaya) {
            $query->whereIn('akun_id', $id_biaya);
        })->sum('saldo');

        $kredit = $pengeluaran + $biaya;
        $debit = Transaksi::where('akun_id', 1)->where('jenis_saldo', 1)->where('status', 1)->sum('saldo');
        return $debit - $kredit;
    }

    public function akun() {
        return $this->belongsTo('App\Akun');
    }

    public function jurnal() {
        return $this->belongsTo('App\Jurnal');
    }

    public function penjualan() {
        return $this->hasOne('App\TransaksiPenjualan');
    }

    public function pembelian() {
        return $this->hasOne('App\TransaksiPembelian');
    }

    public function child() {
        return $this->hasMany('App\Transaksi', 'reff_id', 'id');
    }
}

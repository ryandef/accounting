<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Transaksi;

class Akun extends Model
{
    public function transaksi() {
        return $this->hasMany('App\Transaksi');
    }

    public function transaksiDebitTotal() {
        $data = Transaksi::where('jenis_saldo', 1);

        if (\Request::get('start')) {
            $data->whereDate('tanggal', '>=', \Request::get('start'));
        }

        if (\Request::get('end')) {
            $data->whereDate('tanggal', '<=', \Request::get('end'));
        }


        $data = $data->where('akun_id', $this->id)
                ->sum('saldo');
        return $data;
    }

    public function transaksiKreditTotal() {
        $data = Transaksi::where('jenis_saldo', 2);

        if (\Request::get('start')) {
            $data->whereDate('tanggal', '>=', \Request::get('start'));
        }

        if (\Request::get('end')) {
            $data->whereDate('tanggal', '<=', \Request::get('end'));
        }


        $data = $data->where('akun_id', $this->id)
                ->sum('saldo');
        return $data;
    }
}

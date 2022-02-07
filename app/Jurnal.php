<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Akun;

class Jurnal extends Model
{
    public function satuTransaksi()
    {
        return $this->hasOne('App\Transaksi');
    }
    public function transaksi()
    {
        return $this->hasMany('App\Transaksi');
    }
    public function jurnal()
    {
        return $this->hasMany('App\Jurnal', 'parent_id');
    }
    public function penjualan()
    {
        return $this->hasOne('App\TransaksiPenjualan');
    }
    public function pembelian()
    {
        return $this->hasOne('App\TransaksiPembelian');
    }
    public function isBiaya()
    {
        $data = false;

        $id_biaya = Akun::select('id')->where(function ($query) {
            $query->where('id', 11)
                ->orWhere('parent_id', 11);
        })->get();

        $check = Transaksi::where('jurnal_id', $this->id)->whereIn('akun_id', $id_biaya)->count();

        if($check > 0) {
            return true;
        }

        return $data;

    }

    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            $model->no_jurnal = 'INV'.date('YmdHis');
        });
    }
}

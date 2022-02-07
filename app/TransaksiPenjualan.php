<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiPenjualan extends Model
{
    public function pelanggan() {
        return $this->belongsTo('App\Pelanggan');
    }
    public function jurnal() {
        return $this->belongsTo('App\Jurnal');
    }
}

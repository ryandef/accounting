<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiPembelian extends Model
{
    public function supplier() {
        return $this->belongsTo('App\Supplier');
    }
    public function jurnal() {
        return $this->belongsTo('App\Jurnal');
    }
}

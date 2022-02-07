<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/generate', function () {
    $data = \App\Jurnal::all();

    foreach ($data as $key => $item) {
        $item->no_jurnal = 'INV'.date('YmdHis', strtotime($item->created_at));
        $item->save();
    }
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::name('admin.')->prefix('admin')->namespace('Admin')->group(function () {
        Route::get('/', 'IndexController@index')->name('index');

        Route::get('/akun', 'AkunController@index')->name('akun.index');
        Route::post('/akun', 'AkunController@store')->name('akun.store');
        Route::delete('/akun/{id}', 'AkunController@destroy')->name('akun.destroy');
        Route::put('/akun/{id}', 'AkunController@update')->name('akun.update');

        Route::get('/supplier', 'SupplierController@index')->name('supplier.index');
        Route::post('/supplier', 'SupplierController@store')->name('supplier.store');
        Route::delete('/supplier/{id}', 'SupplierController@destroy')->name('supplier.destroy');
        Route::put('/supplier/{id}', 'SupplierController@update')->name('supplier.update');

        Route::get('/pelanggan', 'PelangganController@index')->name('pelanggan.index');
        Route::post('/pelanggan', 'PelangganController@store')->name('pelanggan.store');
        Route::delete('/pelanggan/{id}', 'PelangganController@destroy')->name('pelanggan.destroy');
        Route::put('/pelanggan/{id}', 'PelangganController@update')->name('pelanggan.update');

        Route::get('/penjualan', 'PenjualanController@index')->name('penjualan.index');
        Route::get('/penjualan/{id}/lunas', 'PenjualanController@lunas')->name('penjualan.lunas');
        Route::get('/penjualan/create', 'PenjualanController@create')->name('penjualan.create');
        Route::get('/penjualan/{id}/edit', 'PenjualanController@edit')->name('penjualan.edit');
        Route::post('/penjualan', 'PenjualanController@store')->name('penjualan.store');
        Route::get('/penjualan/{id}', 'PenjualanController@show')->name('penjualan.show');
        Route::put('/penjualan/{id}', 'PenjualanController@update')->name('penjualan.update');

        Route::get('/pembelian', 'PembelianController@index')->name('pembelian.index');
        Route::get('/pembelian/{id}/lunas', 'PembelianController@lunas')->name('pembelian.lunas');
        Route::get('/pembelian/create', 'PembelianController@create')->name('pembelian.create');
        Route::get('/pembelian/{id}/edit', 'PembelianController@edit')->name('pembelian.edit');
        Route::post('/pembelian', 'PembelianController@store')->name('pembelian.store');
        Route::get('/pembelian/{id}', 'PembelianController@show')->name('pembelian.show');
        Route::put('/pembelian/{id}', 'PembelianController@update')->name('pembelian.update');

        Route::get('/biaya', 'BiayaController@index')->name('biaya.index');
        Route::get('/biaya/create', 'BiayaController@create')->name('biaya.create');
        Route::post('/biaya', 'BiayaController@store')->name('biaya.store');
        Route::get('/biaya/{id}/edit', 'BiayaController@edit')->name('biaya.edit');
        Route::put('/biaya/{id}', 'BiayaController@update')->name('biaya.update');

        Route::get('/jurnal-umum', 'JurnalController@index')->name('jurnal-umum.index');
        Route::get('/jurnal-umum/create', 'JurnalController@create')->name('jurnal-umum.create');
        Route::get('/jurnal-umum/{id}/edit', 'JurnalController@edit')->name('jurnal-umum.edit');
        Route::put('/jurnal-umum/{id}', 'JurnalController@update')->name('jurnal-umum.update');
        Route::post('/jurnal-umum', 'JurnalController@store')->name('jurnal-umum.store');
        Route::delete('/jurnal-umum/{id}', 'JurnalController@destroy')->name('jurnal-umum.destroy');
        Route::put('/jurnal-umum/{id}', 'JurnalController@update')->name('jurnal-umum.update');

        Route::get('/laporan/jurnal-umum', 'LaporanController@jurnalUmum')->name('laporan.jurnalUmum');
        Route::get('/laporan/buku-besar', 'LaporanController@bukuBesar')->name('laporan.bukuBesar');
        Route::get('/laporan/neraca-saldo', 'LaporanController@neracaSaldo')->name('laporan.neracaSaldo');
        Route::get('/laporan/laba-rugi', 'LaporanController@labaRugi')->name('laporan.labaRugi');
        Route::get('/laporan/arus-kas', 'LaporanController@arusKas')->name('laporan.arusKas');

    });
});


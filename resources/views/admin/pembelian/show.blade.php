@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Detail Pembelian
@endsection
{{-- CSS Datatables --}}
@section('head')
    <link rel="stylesheet" href="/vendor/datatables/dataTables.bootstrap4.min.css">
@endsection
{{-- Back Button --}}
@section('back_button')
    <a href="{{ route('admin.penjualan.index') }}" class="mb-2 d-block text-gray-800"><small><i class="fa fa-arrow-left"></i>
            Kembali</small></a>
@endsection
{{-- Content --}}
@section('content')
    {{-- Breadcrumbs --}}
    <div class="row">
        <div class="col-lg-12">
            <small>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-gray-800"
                                href="{{ route('admin.index') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Detail Pembelian</li>
                    </ol>
                </nav>
            </small>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <b>Informasi</b>
                    <hr>
                    Penjual : {{$model->supplier->nama}} <br>
                    Total : {{number_format($model->jurnal->satuTransaksi->saldo)}} <br>
                    Tipe Penjualan :

                    @if ($model->tipe == 1)
                        <span class="badge badge-success">Tunai</span>
                    @else
                        <span class="badge badge-primary">Kredit</span>
                    @endif
                    @if ($model->status == 1)
                        <span class="badge badge-success">Lunas</span>
                    @else
                        <span class="badge badge-danger">Belum Lunas</span>
                    @endif

                    @if ($model->status == 0 && \Auth::user()->type == 1)
                        <br> <br>
                        <a href="{{route('admin.pembelian.lunas', $model->id)}}" class="btn btn-block btn-primary btn-sm">Buat Lunas</a>

                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <b>Transaksi Pembelian</b> <br> <br>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    No
                                </th>
                                <th>
                                    Nama Akun
                                </th>
                                <th>
                                    Debet
                                </th>
                                <th>Kredit</th>
                            </tr>
                        </thead>
                        <tbody>


                            @foreach ($model->jurnal->transaksi as $i => $item)
                            <tr>
                                <td>{{$i + 1}}</td>
                                <td>{{$item->akun->keterangan}}</td>
                                <td>
                                    @if ($item->jenis_saldo == 1)
                                        {{ number_format($item->saldo) }}
                                    @endif
                                </td>
                                <td>
                                    @if ($item->jenis_saldo == 2)
                                        {{ number_format($item->saldo) }}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($model->jurnal->jurnal->count() > 0)
            <div class="card mb-4">
                <div class="card-body">
                    <b>Transaksi Pelunasan</b> <br> <br>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    No
                                </th>
                                <th>
                                    Nama Akun
                                </th>
                                <th>
                                    Debet
                                </th>
                                <th>Kredit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($model->jurnal->jurnal as $i => $jurnal)
                            @foreach ($jurnal->transaksi as $j => $item)
                            <tr>
                                <td>{{$j + 1}}</td>
                                <td>{{$item->akun->keterangan}}</td>
                                <td>
                                    @if ($item->jenis_saldo == 1)
                                        {{ number_format($item->saldo) }}
                                    @endif
                                </td>
                                <td>
                                    @if ($item->jenis_saldo == 2)
                                        {{ number_format($item->saldo) }}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>

@endsection


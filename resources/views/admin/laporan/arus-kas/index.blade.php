@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Laporan Arus Kas
@endsection
{{-- CSS Datatables --}}
@section('head')
    <link rel="stylesheet" href="/vendor/datatables/dataTables.bootstrap4.min.css">
@endsection
{{-- Back Button --}}
@section('back_button')
    <a href="{{ route('admin.index') }}" class="mb-2 d-block text-gray-800"><small><i class="fa fa-arrow-left"></i>
            Kembali</small></a>
@endsection


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
                        <li class="breadcrumb-item" aria-current="page">Laporan Arus Kas</li>
                    </ol>
                </nav>
            </small>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="" method="GET" class="form-inline">
                <div class="form-group text-gray-800 mr-4">
                    <label for="">Mulai</label>
                    <input type="date" value="{{ \Request::get('start') }}" name="start" class="form-control ml-2" id="">
                </div>
                <div class="form-group text-gray-800 mr-2">
                    <label for="">Hingga</label>
                    <input type="date" value="{{ \Request::get('end') }}" name="end" class="form-control ml-2" id="">
                </div>
                <div class="form-group text-gray-800 mr-2">
                    <button type="submit" class="btn btn-primary" name="submit" value="search"><i
                            class="fa fa-search"></i> Filter</button>
                </div>
                <div class="form-group text-gray-800 mr-2">
                    <button type="submit" class="btn btn-danger" name="submit" value="pdf"><i class="fa fa-file"></i>
                        Export PDF</button>
                </div>
            </form>
            <hr>
            <div class="alert alert-info text-center">
                <h5>
                    <strong>Laporan Arus Kas</strong>
                </h5>
                @if ($deskripsi)
                    <span>{{$deskripsi}}</span>
                @endif
            </div>
            <h6 class="text-gray-800"><b>Aktivitas Operasi</b></h6>
            <div class="text-gray-800">
                <p>Penerimaan Kas dari</p>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <td style="width:50%;">Penerimaan kas dari pelanggan</td>
                            <td>{{number_format($pendapatan)}}</td>
                        </tr>
                    </thead>
                </table>
                <p>Pembayaran Kas ke</p>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <td style="width:50%;">Pembayaran Kas ke Supplier</td>
                            <td>{{number_format($pengeluaran)}}</td>
                        </tr>
                        <tr>
                            <td style="width:50%;">Biaya Operasional Perusahaan</td>
                            <td>{{number_format($biaya)}}</td>
                        </tr>
                    </thead>
                </table>
            </div>
            <h6 class="text-gray-800"><b>Kas diterima dari aktivitas operasi : {{number_format( $pendapatan - $biaya - $pengeluaran )}}</b></h6>
        </div>
    </div>
@endsection

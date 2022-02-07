@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Laporan Neraca Saldo
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
                        <li class="breadcrumb-item" aria-current="page">Laporan Neraca Saldo</li>
                    </ol>
                </nav>
            </small>
        </div>
    </div>
    <div class="card mb-4">
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
            @if ($models != null)
            <div class="alert alert-info text-center">
                <h5>
                    <strong>Laporan Neraca Saldo</strong>
                </h5>
                @if ($deskripsi)
                    <span>{{$deskripsi}}</span>
                @endif
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 10%;">No Akun</th>
                            <th style="width: 30%;">Akun</th>
                            <th style="width: 20%;">Debet</th>
                            <th style="width: 20%;">Kredit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $debet = 0;
                            $kredit = 0;
                        @endphp
                        @foreach ($models as $item)
                            <tr>
                                <td>
                                    {{$item->no_reff}}
                                </td>
                                <td>
                                    {{$item->nama_reff}}
                                </td>
                                <td>
                                    {{number_format($item->transaksiDebitTotal())}}
                                    @php
                                        $debet += $item->transaksiDebitTotal();
                                    @endphp
                                </td>
                                <td>
                                    {{number_format($item->transaksiKreditTotal())}}
                                    @php
                                        $kredit += $item->transaksiKreditTotal();
                                    @endphp
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2"></th>
                            <th>
                                {{number_format($debet)}}
                            </th>
                            <th>
                                {{number_format($kredit)}}
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @endif

    </div>
@endsection


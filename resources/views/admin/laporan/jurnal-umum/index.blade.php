@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Laporan Jurnal Umum
@endsection
{{-- Back Button --}}
@section('back_button')
    <a href="{{ route('admin.index') }}" class="mb-2 d-block text-gray-800"><small><i class="fa fa-arrow-left"></i>
            Kembali</small></a>
@endsection

@section('content')
    <style>
        td[rowspan="2"] {
            vertical-align: middle;
        }

    </style>
    {{-- Breadcrumbs --}}
    <div class="row">
        <div class="col-lg-12">
            <small>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-gray-800"
                                href="{{ route('admin.index') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Laporan Jurnal Umum</li>
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
            @if ($models != null)
                <div class="alert alert-info text-center">
                    <h5>
                        <strong>Laporan Jurnal Umum</strong>
                    </h5>
                    @if ($deskripsi)
                        <span>{{ $deskripsi }}</span>
                    @endif
                </div>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>No Transaksi</th>
                            <th>Akun</th>
                            <th>Debet</th>
                            <th>Kredit</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($models as $row)
                            @foreach ($row->transaksi as $i => $item)
                                @if ($i == 0)
                                    <tr>
                                        <td rowspan="2">
                                            <small>{{ date('d-m-Y', strtotime($row->tanggal)) }}</small>
                                        </td>
                                        <td rowspan="2">
                                            <small>{{ $row->no_jurnal }}</small>
                                        </td>
                                        <td>
                                            <small>{{ $item->akun->nama_reff }}</small>
                                        </td>
                                        <td>
                                            <small>{{ number_format($item->saldo) }}</small>
                                        </td>
                                        <td></td>
                                        <td rowspan="2">
                                            <small>{{ $row->catatan }}</small>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td><small>{{ $item->akun->nama_reff }}</small></td>
                                        <td></td>
                                        <td>
                                            <small>{{ number_format($item->saldo) }}</small>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection

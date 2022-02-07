@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Laporan Buku Besar
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
                        <li class="breadcrumb-item" aria-current="page">Laporan Buku Besar</li>
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
                    <strong>Laporan Buku Besar</strong>
                </h5>
                @if ($deskripsi)
                    <span>{{$deskripsi}}</span>
                @endif
            </div>
            @foreach ($models as $akun => $row)
            <p class="text-gray-800"><b>Akun {{$akun}}</b></p>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 15%;">Tanggal</th>
                            <th style="width: 40%;">Catatan</th>
                            <th style="width: 15%;">Debet</th>
                            <th style="width: 15%;">Kredit</th>
                            <th style="width: 15%;">Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $saldo = 0;
                            $debet = 0;
                            $kredit = 0;
                        @endphp
                        @foreach ($row as $item)
                            <tr>
                                <td>{{date('d M Y', strtotime($item->tanggal))}}</td>
                                <td>{{ $item->catatan }}</td>
                                <td>
                                    @if ($item->jenis_saldo == 1)
                                        @php
                                            $debet += $item->saldo;
                                            $saldo += $item->saldo;
                                        @endphp
                                        {{ number_format($item->saldo ? $item->saldo : 0) }}
                                    @endif
                                </td>
                                <td>
                                    @if ($item->jenis_saldo == 2)
                                        @php
                                            $kredit += $item->saldo;
                                            $saldo -= $item->saldo;
                                        @endphp
                                        {{ number_format($item->saldo) }}
                                    @endif
                                </td>
                                <td>
                                    {{ number_format($saldo) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
            @endforeach
            @endif

    </div>
@endsection

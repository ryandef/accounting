@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Laporan Laba Rugi
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
<style>
    table.tabss tr td{
        width: 50%;
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
                        <li class="breadcrumb-item" aria-current="page">Laporan Laba Rugi</li>
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
            @if ($pendapatan != null || $pengeluaran != null)
                <div class="alert alert-info text-center">
                    <h5>
                        <strong>Laporan Laba Rugi</strong>
                    </h5>
                    @if ($deskripsi)
                        <span>{{ $deskripsi }}</span>
                    @endif
                </div>
                <div class="table-responsive">
                    <p><b class="text-gray-800">Pendapatan</b></p>
                    <table class="table table-bordered tabss" id="dataTable" width="100%" cellspacing="0">
                        <tbody>
                            @php
                                $saldo = 0;
                            @endphp
                            @foreach ($pendapatan as $i => $item)
                                <tr>
                                    <td>
                                        {{ \App\Akun::find($i)->nama_reff }}
                                    </td>
                                    <td>
                                        {{ number_format($item->sum('saldo')) }}
                                        @php
                                            $saldo += $item->sum('saldo');
                                        @endphp
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total Pendapatan</th>
                                <th>
                                    {{ number_format($saldo) }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>

                    <br>
                    <p><b class="text-gray-800">Beban</b></p>
                    <table class="table table-bordered tabss" id="dataTable" width="100%" cellspacing="0">
                        <tbody>
                            @php
                                $saldoKredit = 0;
                                $biayas = 0;
                            @endphp
                            @foreach ($pengeluaran as $i => $item)
                                <tr>
                                    <td>
                                        {{ \App\Akun::find($i)->nama_reff }}
                                    </td>
                                    <td>
                                        {{ number_format($item->sum('saldo')) }}
                                        @php
                                            $saldoKredit += $item->sum('saldo');
                                        @endphp
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>
                                    Beban Operasional
                                </td>
                                <td>
                                    @foreach ($biaya as $i => $item)
                                    @php
                                        $biayas += $item->sum('saldo');
                                        $saldoKredit += $item->sum('saldo');
                                    @endphp
                                    @endforeach

                                    {{ number_format($biayas) }}
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total Beban</th>
                                <th>
                                    {{ number_format($saldoKredit) }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <br>
                <div class="alert alert-info">
                    @if ($saldo > $saldoKredit)
                        <b>Laba</b> : {{ number_format($saldo - $saldoKredit) }}
                    @elseif ($saldoKredit > $saldo)
                        <b>Rugi</b> : {{ number_format($saldoKredit - $saldo) }}
                    @else
                        <b>Seimbang</b>
                    @endif
                </div>
            @endif

        </div>
    @endsection

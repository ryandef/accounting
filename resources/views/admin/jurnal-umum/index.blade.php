@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Jurnal Umum
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
{{-- Content --}}
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
                        <li class="breadcrumb-item" aria-current="page">Jurnal Umum</li>
                    </ol>
                </nav>
            </small>
        </div>
    </div>
    {{-- Tambah Data --}}
    <a href="{{route('admin.jurnal-umum.create')}}" class="btn btn-primary btn-icon-split shadow">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Tambah Data</span>
    </a>


    <br><br>
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="" method="GET" class="form-inline">
                <div class="form-group text-gray-800 mr-4">
                    <label for="">No Transaksi</label>
                    <input type="text" value="{{ \Request::get('no_jurnal') }}" name="no_jurnal" class="form-control ml-2" id="">
                </div>
                <div class="form-group text-gray-800 mr-4">
                    <label for="">Mulai</label>
                    <input type="date" value="{{ \Request::get('start') }}" name="start" class="form-control ml-2" id="">
                </div>
                <div class="form-group text-gray-800 mr-2">
                    <label for="">Hingga</label>
                    <input type="date" value="{{ \Request::get('end') }}" name="end" class="form-control ml-2" id="">
                </div>
                <div class="form-group text-gray-800 mr-2">
                    <button type="submit" class="btn btn-success" name="submit" value="search"><i
                            class="fa fa-search"></i> Filter</button>
                </div>
                <div class="form-group text-gray-800 mr-2">
                    <a href="{{route('admin.jurnal-umum.index')}}" class="btn btn-danger"><i class="fa fa-file"></i>
                        Reset</a>
                </div>
            </form>
        </div>
    </div>
    {{-- Table --}}
    <div class="card shadow mb-4">
        <!-- Card Body -->
        <div class="card-body ">
            <div class="table-responsive">
                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>No Transaksi</th>
                            <th>Akun</th>
                            <th>Debet</th>
                            <th>Kredit</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
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
                                        <td rowspan="2">
                                            @if (\Auth::user()->type == 1)
                                                @if ((date('Y', strtotime($row->created_at)) < date('Y')) || $row->pembelian != null || $row->penjualan != null || $row->parent_id != null || $row->isBiaya() == true)
                                                    <button class="btn btn-warning btn-sm" disabled>Edit</button>
                                                @else
                                                    <a href="{{ route('admin.jurnal-umum.edit', $row->id) }}"
                                                        class="btn btn-warning btn-sm">Edit</a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td><small>{{ $item->akun->nama_reff }}</small></td>
                                        <td></td>
                                        <td>
                                           <small> {{ number_format($item->saldo) }}</small>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                    {{-- <tbody> --}}
                        {{-- @forelse ($models as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td @if($item->jenis_saldo == 2) style="padding-left: 30px;" @endif>{{ $item->akun->keterangan}}</td>
                                <td>{{ $item->tanggal }}</td>
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
                        @empty
                            <tr>
                                <td colspan="5">Belum ada data</td>
                            </tr>
                        @endforelse --}}
                    {{-- </tbody> --}}
                </table>
                {!!$models->links()!!}
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });

        function deleteData(id) {
            swal({
                    title: "Yakin ingin menghapus data?",
                    text: "Setelah dihapus, Anda tidak akan dapat memulihkan data tersebut",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $(id).unbind('submit').submit()

                    } else {
                        return false;
                    }
                });
        }
    </script>
@endsection

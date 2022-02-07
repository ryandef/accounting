@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Biaya
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
    {{-- Breadcrumbs --}}
    <div class="row">
        <div class="col-lg-12">
            <small>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-gray-800"
                                href="{{ route('admin.index') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Biaya</li>
                    </ol>
                </nav>
            </small>
        </div>
    </div>
    {{-- Tambah Data --}}
    @if(\Auth::user()->type == 1)
    <a href="{{route('admin.biaya.create')}}" class="btn btn-primary btn-icon-split shadow">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Tambah Data</span>
    </a>


    <br><br>
    @endif
    <div class="card shadow mb-4">
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
                    <button type="submit" class="btn btn-success" name="submit" value="search"><i
                            class="fa fa-search"></i> Filter</button>
                </div>
                @if (\Request::get('start') || \Request::get('end'))
                    <div class="form-group text-gray-800">
                        <a href="{{ route('admin.biaya.index') }}" class="btn btn-danger"><i
                                class="fa fa-times"></i> Clear</a>
                    </div>
                @endif
            </form>
        </div>
    </div>
    @php
        $total = 0;
    @endphp
    {{-- Table --}}
    <div class="card shadow mb-4">
        <!-- Card Body -->
        <div class="card-body ">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Akun</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($models as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td @if($item->jenis_saldo == 2) style="padding-left: 30px;" @endif>{{ $item->akun->keterangan}}</td>
                                <td>{{ $item->tanggal }}</td>
                                <td>
                                    @if ($item->jenis_saldo == 1)
                                        {{ number_format($item->saldo) }}
                                    @endif
                                    @php
                                        $total += $item->saldo;
                                    @endphp
                                </td>
                                <td>
                                    @if (\Auth::user()->type == 1)
                                    @if (date('Y-m-d H:i:s', strtotime($item->created_at . ' + 9 hours')) < date('Y-m-d H:i:s'))
                                            <button class="btn btn-warning btn-sm" disabled>Edit</button>
                                        @else
                                            <a href="{{ route('admin.biaya.edit', $item->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                        @endif

                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <!-- Card Body -->
        <div class="card-body ">
            <p><strong>Total Biaya</strong> : {{number_format($total)}}</p>
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

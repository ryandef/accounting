@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Daftar Akun
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
                        <li class="breadcrumb-item" aria-current="page">Daftar Akun</li>
                    </ol>
                </nav>
            </small>
        </div>
    </div>
    {{-- Tambah Data --}}
    <a href="javascript:void(0)" class="btn btn-primary btn-icon-split shadow" data-toggle="modal" data-target="#create">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Tambah Data</span>
    </a>
    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.akun.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="" class="label">No Akun</label>
                            <input type="number" class="form-control" value="{{ old('no_reff') }}" autocomplete="off"
                                name="no_reff" required>
                        </div>
                        <div class="form-group">
                            <label for="" class="label">Nama Akun</label>
                            <input type="text" class="form-control" value="{{ old('nama_reff') }}" autocomplete="off"
                                name="nama_reff" required>
                        </div>
                        <div class="form-group">
                            <label for="" class="label">Keterangan</label>
                            <input type="text" class="form-control" value="{{ old('keterangan') }}" autocomplete="off"
                                name="keterangan" required>
                        </div>
                        <div class="form-group">
                            <label for="" class="label">Akun Utama</label>
                            <select class="form-control" name="parent_id">
                                <option value="">Pilih Akun Utama</option>
                                @foreach ($parent as $item)
                                    <option value="{{$item->id}}">{{$item->nama_reff}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <br><br>
    {{-- Table --}}
    <div class="card shadow mb-4">
        <!-- Card Body -->
        <div class="card-body ">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Akun</th>
                            <th>Nama Akun</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($models as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item->no_reff }}</td>
                                <td>{{ $item->nama_reff }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td>
                                    <form id="formDelete-{{ $item->id }}"
                                        action="{{ route('admin.akun.destroy', $item->id) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <a href="javascript:void(0)" class="btn btn-warning btn-circle btn-sm"
                                            data-toggle="modal" data-target="#edit-{{ $item->id }}">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <button type="button" onclick="deleteData('#formDelete-{{ $item->id }}')"
                                            class="btn btn-danger btn-circle btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </form>
                                    <div class="modal fade" id="edit-{{ $item->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.akun.update', $item->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="" class="label">No Akun</label>
                                                            <input type="number" class="form-control" value="{{ $item->no_reff }}" autocomplete="off"
                                                                name="no_reff" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="label">Nama Akun</label>
                                                            <input type="text" class="form-control" value="{{ $item->nama_reff }}" autocomplete="off"
                                                                name="nama_reff" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="label">Keterangan</label>
                                                            <input type="text" class="form-control" value="{{ $item->keterangan }}" autocomplete="off"
                                                                name="keterangan" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="label">Akun Akun Utama</label>
                                                            <select class="form-control" name="parent_id">
                                                                <option value="">Pilih Akun Utama</option>
                                                                @foreach ($parent as $row)
                                                                    <option @if($item->parent_id == $row->id) selected @endif value="{{$row->id}}">{{$row->nama_reff}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-success">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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

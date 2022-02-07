@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Data Pelanggan
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
                        <li class="breadcrumb-item" aria-current="page">Data Pelanggan</li>
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
                <form action="{{ route('admin.pelanggan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="" class="label">Nama Pelanggan</label>
                            <input type="text" class="form-control" value="{{ old('nama') }}" autocomplete="off"
                                name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="" class="label">Alamat</label>
                            <input type="text" class="form-control" value="{{ old('alamat') }}" autocomplete="off"
                                name="alamat" required>
                        </div>
                        <div class="form-group">
                            <label for="" class="label">Email</label>
                            <input type="email" class="form-control" value="{{ old('email') }}" autocomplete="off"
                                name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="" class="label">No Telepon</label>
                            <input type="text" class="form-control" value="{{ old('no_telepon') }}" autocomplete="off"
                                name="no_telepon" required>
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
                            <th>Nama Pelanggan</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>No Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($models as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td>{{ $item->no_telepon }}</td>
                                <td>
                                    <form id="formDelete-{{ $item->id }}"
                                        action="{{ route('admin.pelanggan.destroy', $item->id) }}" method="POST">
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
                                                <form action="{{ route('admin.pelanggan.update', $item->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="" class="label">Nama Pelanggan</label>
                                                            <input type="text" class="form-control" value="{{ $item->nama }}" autocomplete="off"
                                                                name="nama" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="label">Alamat</label>
                                                            <input type="text" class="form-control" value="{{ $item->alamat }}" autocomplete="off"
                                                                name="alamat" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="label">Email</label>
                                                            <input type="email" class="form-control" value="{{ $item->email }}" autocomplete="off"
                                                                name="email" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="" class="label">No Telepon</label>
                                                            <input type="text" class="form-control" value="{{ $item->no_telepon }}" autocomplete="off"
                                                                name="no_telepon" required>
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

@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Edit Jurnal Umum
@endsection
{{-- CSS Datatables --}}
@section('head')
    <link rel="stylesheet" href="/vendor/datatables/dataTables.bootstrap4.min.css">
@endsection
{{-- Back Button --}}
@section('back_button')
    <a href="{{ route('admin.jurnal-umum.index') }}" class="mb-2 d-block text-gray-800"><small><i
                class="fa fa-arrow-left"></i>
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
                        <li class="breadcrumb-item" aria-current="page">Edit Jurnal Umum</li>
                    </ol>
                </nav>
            </small>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.jurnal-umum.update', $model->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Tanggal</label>
                            <input required type="date" name="tanggal" value="{{ $model->tanggal }}"
                                class="form-control" id="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Catatan</label>
                            <input required type="text" name="catatan" value="{{ $model->catatan }}"
                                class="form-control" id="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Saldo</label>
                            <input required type="number" name="saldo" min="1" class="form-control"
                                value="{{ $model->transaksi->first()->saldo }}" id="">
                        </div>
                    </div>
                </div>
                <hr>
                @foreach ($model->transaksi as $i => $row)
                    <div class="row mb-4">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Nama Akun</label>
                                <select class="form-control" name="akun_id[]" id="">
                                    @foreach ($akun as $item)
                                        <option value="{{ $item->id }}" @if ($item->id == $row->akun_id) selected @endif>
                                            {{ $item->nama_reff }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Jenis Saldo</label>
                                <select class="form-control" readonly name="jenis_saldo[]" id="">
                                    @if ($i == 0)
                                        <option value="1" selected>Debit</option>
                                    @else
                                        <option value="2" selected>Kredit</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endforeach


                <button type="submit" class="btn btn-success btn-block">Simpan</button>
            </form>
        </div>
    </div>

@endsection

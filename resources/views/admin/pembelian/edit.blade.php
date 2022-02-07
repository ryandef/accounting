@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Edit Pembelian
@endsection
{{-- CSS Datatables --}}
@section('head')
    <link rel="stylesheet" href="/vendor/datatables/dataTables.bootstrap4.min.css">
@endsection
{{-- Back Button --}}
@section('back_button')
    <a href="{{ route('admin.pembelian.index') }}" class="mb-2 d-block text-gray-800"><small><i
                class="fa fa-arrow-left"></i>
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
                        <li class="breadcrumb-item" aria-current="page">Edit Pembelian</li>
                    </ol>
                </nav>
            </small>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.pembelian.update', $model->id) }}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="">Tanggal</label>
                            <input required type="date" value="{{ $model->tanggal }}" name="tanggal" class="form-control"
                                id="">
                        </div>
                        <div class="form-group">
                            <label for="">Supplier</label>
                            <select class="form-control" name="supplier_id" id="">
                                @foreach ($supplier as $item)
                                    <option @if ($model->supplier_id == $item->id)
                                        selected
                                        @endif value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Total</label>
                            <input required type="number" name="saldo" min="1"
                                value="{{ $model->jurnal->satuTransaksi->saldo }}" class="form-control" id="">
                        </div>
                        <hr>
                        @if ($model->tipe == 1)
                            <span class="badge badge-success">Tunai</span>
                        @else
                            <span class="badge badge-primary">Kredit</span>
                        @endif
                        <br> <br>


                        <button type="submit" class="btn btn-success btn-block">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Tambah Penjualan
@endsection
{{-- CSS Datatables --}}
@section('head')
    <link rel="stylesheet" href="/vendor/datatables/dataTables.bootstrap4.min.css">
@endsection
{{-- Back Button --}}
@section('back_button')
    <a href="{{ route('admin.penjualan.index') }}" class="mb-2 d-block text-gray-800"><small><i class="fa fa-arrow-left"></i>
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
                        <li class="breadcrumb-item" aria-current="page">Tambah Penjualan</li>
                    </ol>
                </nav>
            </small>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.penjualan.store')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Tanggal</label>
                            <input required type="date" name="tanggal" class="form-control" id="">
                        </div>
                        <div class="form-group">
                            <label for="">Pelanggan</label>
                            <select class="form-control" name="pelanggan_id" id="">
                                @foreach ($pelanggan as $item)
                                    <option value="{{$item->id}}">{{$item->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Total</label>
                            <input required type="number" name="saldo" min="1" class="form-control" id="">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="">Tipe</label>
                            <select class="form-control" name="type" id="">
                                <option value="1" selected>Tunai</option>
                                <option value="0">Kredit</option>
                            </select>
                        </div>


                        <button type="submit" class="btn btn-success btn-block">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


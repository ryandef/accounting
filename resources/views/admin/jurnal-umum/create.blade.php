@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Tambah Jurnal Umum
@endsection
{{-- CSS Datatables --}}
@section('head')
    <link rel="stylesheet" href="/vendor/datatables/dataTables.bootstrap4.min.css">
@endsection
{{-- Back Button --}}
@section('back_button')
    <a href="{{ route('admin.jurnal-umum.index') }}" class="mb-2 d-block text-gray-800"><small><i class="fa fa-arrow-left"></i>
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
                        <li class="breadcrumb-item" aria-current="page">Tambah Jurnal Umum</li>
                    </ol>
                </nav>
            </small>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="formSubmit" action="{{route('admin.jurnal-umum.store')}}" method="post">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Tanggal</label>
                            <input required type="date" name="tanggal" class="form-control" id="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Catatan</label>
                            <input required type="text" name="catatan" class="form-control" id="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Saldo</label>
                            <input id="total" required type="number" name="saldo" min="1" class="form-control" id="">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row mb-4">
                    <div class="col">
                        <div class="form-group">
                            <label for="">Nama Akun</label>
                            <select id="debit" class="form-control" name="akun_id[]" id="">
                                @foreach ($akun as $item)
                                    <option value="{{$item->id}}">{{$item->nama_reff}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="">Jenis Saldo</label>
                            <select  class="form-control" readonly name="jenis_saldo[]" id="">
                                <option value="1" selected>Debit</option>
                            </select>
                        </div>
                    </div>


                </div>
                <hr>
                <div class="row mb-4">
                    <div class="col">
                        <div class="form-group">
                            <label for="">Nama Akun</label>
                            <select id="kredit" class="form-control" name="akun_id[]" id="">
                                @foreach ($akun as $item)
                                    <option value="{{$item->id}}">{{$item->nama_reff}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="">Jenis Saldo</label>
                            <select  class="form-control" readonly name="jenis_saldo[]" id="">
                                <option value="2" selected>Kredit</option>
                            </select>
                        </div>
                    </div>


                </div>
                <button type="submit" class="btn btn-success btn-block">Simpan</button>
            </form>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $('#formSubmit').on('submit', function(e){
            e.preventDefault();
            var kas = "{{$kas}}";
            var total = $('#total').val();
            var kredit = $('#kredit').val();
            var debit = $('#debit').val();
            if(kredit == debit) {
                alert('Jenis akun harus berbeda');
                return false;
            }
            if(parseInt(total) > parseInt(kas) && kredit == 1) {
                swal({
                    title: "Yakin ingin menambah transaksi di jurnal umum?",
                    text: "Total kas saat ini {{number_format($kas)}}",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $('#formSubmit').unbind('submit').submit();
                    } else {
                        return false;
                    }
                });
            } else {
                $('#formSubmit').unbind('submit').submit();
            }

        });
    </script>
@endsection

@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Tambah Pembelian
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
                        <li class="breadcrumb-item" aria-current="page">Tambah Pembelian</li>
                    </ol>
                </nav>
            </small>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form id="formSubmit" action="{{ route('admin.pembelian.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Tanggal</label>
                            <input required type="date" name="tanggal" class="form-control" id="">
                        </div>
                        <div class="form-group">
                            <label for="">Supplier</label>
                            <select class="form-control" name="supplier_id" id="">
                                @foreach ($supplier as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Total</label>
                            <input id="total" required type="number" name="saldo" min="1" class="form-control" id="">
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

@section('script')
    <script>
        $('#formSubmit').on('submit', function(e){
            e.preventDefault();
            var kas = "{{$kas}}";
            var total = $('#total').val();
            if(parseInt(total) > parseInt(kas)) {
                // if(confirm('Total kas saat ini {{number_format($kas)}}, apakah anda yakin untuk melanjutkan transaksi?') == false) {
                //     return false;
                // }
                swal({
                    title: "Yakin ingin menambah transaksi pembelian?",
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

<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }

    </style>
    @include('admin.laporan.header')
    <div style="margin-bottom: 30px; padding: 20px 0 0px; text-align: center;">
        <p>
            <b>Laporan Arus Kas</b>
            @if ($deskripsi != null)
                <br>
                {{ $deskripsi }}
            @endif
        </p>
    </div>
    <h6 class="text-gray-800"><b>Aktivitas Operasi</b></h6>
            <div class="text-gray-800">
                <p>Penerimaan Kas dari</p>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <td style="width:50%;">Penerimaan kas dari pelanggan</td>
                            <td>{{number_format($pendapatan)}}</td>
                        </tr>
                    </thead>
                </table>
                <p>Pembayaran Kas ke</p>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <td style="width:50%;">Pembayaran Kas ke Supplier</td>
                            <td>{{number_format($pengeluaran)}}</td>
                        </tr>
                        <tr>
                            <td style="width:50%;">Biaya Operasional Perusahaan</td>
                            <td>{{number_format($biaya)}}</td>
                        </tr>
                    </thead>
                </table>
            </div>
            <h6 class="text-gray-800"><b>Kas diterima dari aktivitas operasi : {{number_format( $pendapatan - $biaya - $pengeluaran )}}</b></h6>

</body>

</html>

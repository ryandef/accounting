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

        td[rowspan="2"] {
            vertical-align: middle;
        }

    </style>
    @include('admin.laporan.header')
    <div style="margin-bottom: 30px; padding: 20px 0 0px; text-align: center;">
        <p>
            <b>Laporan Jurnal Umum</b>
            @if ($deskripsi != null)
                <br>
                {{ $deskripsi }}
            @endif
        </p>
    </div>
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>No Transaksi</th>
                <th>Akun</th>
                <th>Debet</th>
                <th>Kredit</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($models as $row)
                @foreach ($row->transaksi as $i => $item)
                    @if ($i == 0)
                        <tr>
                            <td rowspan="2">
                                {{ date('d-m-Y', strtotime($row->tanggal)) }}
                            </td>
                            <td rowspan="2">
                                {{ $row->no_jurnal }}
                            </td>
                            <td>
                                {{ $item->akun->nama_reff }}
                            </td>
                            <td>
                                {{ number_format($item->saldo) }}
                            </td>
                            <td></td>
                            <td rowspan="2">
                                {{ $row->catatan }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td>{{ $item->akun->nama_reff }}</td>
                            <td></td>
                            <td>
                                {{ number_format($item->saldo) }}
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
        </tbody>
    </table>

</body>

</html>

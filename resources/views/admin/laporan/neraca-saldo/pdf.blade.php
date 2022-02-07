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
            <b>Laporan Neraca Saldo</b>
            @if ($deskripsi != null)
                <br>
                {{ $deskripsi }}
            @endif
        </p>
    </div>
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th style="width: 10%;">No Akun</th>
                <th style="width: 30%;">Akun</th>
                <th style="width: 20%;">Debet</th>
                <th style="width: 20%;">Kredit</th>
            </tr>
        </thead>
        <tbody>
            @php
                $debet = 0;
                $kredit = 0;
            @endphp
            @foreach ($models as $item)
                <tr>
                    <td>
                        {{$item->no_reff}}
                    </td>
                    <td>
                        {{$item->nama_reff}}
                    </td>
                    <td>
                        {{number_format($item->transaksiDebitTotal())}}
                        @php
                            $debet += $item->transaksiDebitTotal();
                        @endphp
                    </td>
                    <td>
                        {{number_format($item->transaksiKreditTotal())}}
                        @php
                            $kredit += $item->transaksiKreditTotal();
                        @endphp
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2"></th>
                <th>
                    {{number_format($debet)}}
                </th>
                <th>
                    {{number_format($kredit)}}
                </th>
            </tr>
        </tfoot>
    </table>

</body>

</html>

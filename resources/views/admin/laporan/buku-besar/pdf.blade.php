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
            <b>Laporan Buku Besar</b>
            @if ($deskripsi != null)
                <br>
                {{ $deskripsi }}
            @endif
        </p>
    </div>
    @foreach ($models as $akun => $row)
        <p class="text-gray-800"><b>Akun {{ $akun }}</b></p>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="width: 15%;">Tanggal</th>
                        <th style="width: 40%;">Akun</th>
                        <th style="width: 15%;">Debet</th>
                        <th style="width: 15%;">Kredit</th>
                        <th style="width: 15%;">Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $saldo = 0;
                        $debet = 0;
                        $kredit = 0;
                    @endphp
                    @foreach ($row as $item)
                        <tr>
                            <td>{{ date('d M Y', strtotime($item->tanggal)) }}</td>
                            <td>{{ $item->catatan }}</td>
                            <td>
                                @if ($item->jenis_saldo == 1)
                                    @php
                                        $debet += $item->saldo;
                                        $saldo += $item->saldo;
                                    @endphp
                                    {{ number_format($item->saldo ? $item->saldo : 0) }}
                                @endif
                            </td>
                            <td>
                                @if ($item->jenis_saldo == 2)
                                    @php
                                        $kredit += $item->saldo;
                                        $saldo -= $item->saldo;
                                    @endphp
                                    {{ number_format($item->saldo) }}
                                @endif
                            </td>
                            <td>
                                {{ number_format($saldo) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    @endforeach

</body>

</html>

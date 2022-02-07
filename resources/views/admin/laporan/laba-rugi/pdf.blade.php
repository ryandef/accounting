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
            <b>Laporan Laba Rugi</b>
            @if ($deskripsi != null)
                <br>
                {{ $deskripsi }}
            @endif
        </p>
    </div>
    <p><b class="text-gray-800">Pendapatan</b></p>
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <tbody>
            @php
                $saldo = 0;
            @endphp
            @foreach ($pendapatan as $i => $item)
                <tr>
                    <td>
                        {{ \App\Akun::find($i)->nama_reff }}
                    </td>
                    <td>
                        {{ number_format($item->sum('saldo')) }}
                        @php
                            $saldo += $item->sum('saldo');
                        @endphp
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Total Pendapatan</th>
                <th>
                    {{ number_format($saldo) }}
                </th>
            </tr>
        </tfoot>
    </table>
    <br>
    <p><b class="text-gray-800">Beban</b></p>
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <tbody>
            @php
                $saldoKredit = 0;
                $biayas = 0;
            @endphp
            @foreach ($pengeluaran as $i => $item)
                <tr>
                    <td>
                        {{ \App\Akun::find($i)->nama_reff }}
                    </td>
                    <td>
                        {{ number_format($item->sum('saldo')) }}
                        @php
                            $saldoKredit += $item->sum('saldo');
                        @endphp
                    </td>
                </tr>
            @endforeach
            <tr>
                <td>
                    Beban Operasional
                </td>
                <td>
                    @foreach ($biaya as $i => $item)
                    @php
                        $biayas += $item->sum('saldo');
                        $saldoKredit += $item->sum('saldo');
                    @endphp
                    @endforeach

                    {{ number_format($biayas) }}
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th>Total Beban</th>
                <th>
                    {{ number_format($saldoKredit) }}
                </th>
            </tr>
        </tfoot>
    </table>
    <br>
    <div class="alert alert-info">
        @if ($saldo > $saldoKredit)
            <b>Laba</b> : {{ number_format($saldo - $saldoKredit) }}
        @elseif ($saldoKredit > $saldo)
            <b>Rugi</b> : {{ number_format($saldoKredit - $saldo) }}
        @else
            <b>Seimbang</b>
        @endif
    </div>

</body>

</html>

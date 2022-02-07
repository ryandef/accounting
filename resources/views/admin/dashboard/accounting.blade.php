@extends('layouts.admin')
{{-- Title --}}
@section('title')
    Dashboard
@endsection
@section('content')
<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Halo,</div>
                        <div class="mb-0 font-weight-bold text-gray-800">{{Auth::user()->name}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary h-100 py-2">
            <div class="card-body">
                <a href="{{route('admin.penjualan.index')}}?start={{date('Y-m-d')}}&end={{date('Y-m-d')}}">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Penjualan Hari Ini</div>
                            <div class="mb-0 font-weight-bold text-gray-800">{{number_format($data['penjualan'])}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary h-100 py-2">
            <div class="card-body">
                <a href="{{route('admin.biaya.index')}}?start={{date('Y-m-d')}}&end={{date('Y-m-d')}}">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Biaya Hari Ini</div>
                            <div class="mb-0 font-weight-bold text-gray-800">{{number_format($data['biaya'])}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row mb-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Grafik Penjualan
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
        <hr>
    </div>
</div>
{{-- <div class="row mb-2">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Grafik Laba Rugi
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChartLabaRugi"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Biaya Operasional
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myPieChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="row mb-2">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Data Penjualan Terakhir
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="alert alert-success">
                            <small>
                                <b>Penjualan Lunas</b> <br>
                                {{number_format($data['penjualan_lunas'])}}
                            </small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="alert alert-danger">
                            <small>
                                <b>Penjualan Belum Lunas</b> <br>
                                {{number_format($data['penjualan_piutang'])}}
                            </small>
                        </div>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <th>No</th>
                        <th>Nominal</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        @forelse ($data['list_penjualan'] as $i => $item)
                        <tr>
                            <td><small>{{ $i + 1 }}</small></td>
                            <td><small>{{ number_format($item->jurnal->satuTransaksi->saldo) }}</small></td>
                            <td><small>{{ $item->tanggal }}</small></td>
                            <td>
                                @if ($item->status == 1)
                                    <span class="badge badge-success">Lunas</span>
                                @else
                                    <span class="badge badge-danger">Belum Lunas</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="4">Belum ada data</td>
                            </tr>
                        @endforelse
                </table>
                <a href="{{route('admin.penjualan.index')}}">Lihat data penjualan</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Data Pembelian Terakhir
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="alert alert-success">
                            <small>
                                <b>Pembelian Lunas</b> <br>
                                {{number_format($data['pembelian_lunas'])}}
                            </small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="alert alert-danger">
                            <small>
                                <b>Pembelian Belum Lunas</b> <br>
                                {{number_format($data['pembelian_utang'])}}
                            </small>
                        </div>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <th>No</th>
                        <th>Nominal</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        @forelse ($data['list_pembelian'] as $i => $item)
                        <tr>
                            <td><small>{{ $i + 1 }}</small></td>
                            <td><small>{{ number_format($item->jurnal->satuTransaksi->saldo) }}</small></td>
                            <td><small>{{ $item->tanggal }}</small></td>
                            <td>
                                @if ($item->status == 1)
                                    <span class="badge badge-success">Lunas</span>
                                @else
                                    <span class="badge badge-danger">Belum Lunas</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="4">Belum ada data</td>
                            </tr>
                        @endforelse
                </table>
                <a href="{{route('admin.pembelian.index')}}">Lihat data pembelian</a>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
    <script src="/vendor/chart.js/Chart.min.js"></script>
    <script>
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = 'Nunito',
            '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        function number_format(number, decimals, dec_point, thousands_sep) {
            // *     example: number_format(1234.56, 2, ',', ' ');
            // *     return: '1 234,56'
            number = (number + '').replace(',', '').replace(' ', '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

        // Area Chart Example
        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! $data['date_graph'] !!},
                datasets: [{
                    label: "",
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "#42689d",
                    pointRadius: 3,
                    pointBackgroundColor: "#42689d",
                    pointBorderColor: "#42689d",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: {!! $data['check_graph'] !!},
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function(value, index, values) {
                                return number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return number_format(tooltipItem.yLabel);
                        }
                    }
                }
            }
        });


        // Bar Chart Example
        var ctxBar = document.getElementById("myAreaChartLabaRugi");
        var myBarChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: {!! $data['date_laba_graph'] !!},
                datasets: [
                {
                    label: "",
                    lineTension: 0.3,
                    backgroundColor: "#d2f4e8",
                    borderColor: "#42689d",
                    pointRadius: 3,
                    pointBackgroundColor: "#42689d",
                    pointBorderColor: "#42689d",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: {!! $data['check_laba_graph'] !!},

                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function(value, index, values) {
                                return number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return number_format(tooltipItem.yLabel);
                        }
                    }
                }
            }
        });


        // Pie Chart Example
        var ctxPie = document.getElementById("myPieChart");
        var myPieChart = new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: {!! $data['biaya_label_graph'] !!},
            datasets: [{
            data: {!! $data['biaya_graph'] !!},
            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc','#4e73df', '#1cc88a', '#36b9cc'],
            hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf','#2e59d9', '#17a673', '#2c9faf'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
            },
            legend: {
                position: 'bottom',
            },
            cutoutPercentage: 80,
        },
        });

    </script>
@endsection

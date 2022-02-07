<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="ryanadhitama">

    <title>@yield('title') - {{ env('APP_NAME') }}</title>
    <link href="" rel="icon">

    <!-- Custom fonts for this template-->
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="/css/admin.css" rel="stylesheet">

    @yield('head')

</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-blue sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
                <div class="sidebar-brand-text mx-3">
                    {{-- <img width="100%" src="/assets/images/logo.png" alt="Toko Bersih-Bersih"> --}}
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.index') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Manajemen Data
            </div>
            @if(\Auth::user()->type == 1)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.akun.index') }}">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Daftar Akun</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKontak"
                    aria-expanded="true" aria-controls="collapseKontak">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Kontak</span>
                </a>
                <div id="collapseKontak" class="collapse @if (\URL::current() == route('admin.supplier.index') || \URL::current() == route('admin.pelanggan.index')) show @endif"
                    aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item @if (\URL::current() == route('admin.pelanggan.index')) active @endif"
                            href="{{ route('admin.pelanggan.index') }}">Pelanggan</a>
                        <a class="collapse-item @if (\URL::current() == route('admin.supplier.index')) active @endif"
                            href="{{ route('admin.supplier.index') }}">Supplier</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTransaksi"
                    aria-expanded="true" aria-controls="collapseTransaksi">
                    <i class="fas fa-fw fa-wallet"></i>
                    <span>Transaksi Keuangan</span>
                </a>
                <div id="collapseTransaksi" class="collapse
                @if (\URL::current() == route('admin.pembelian.index') || \URL::current() == route('admin.penjualan.index') || \URL::current() == route('admin.biaya.index') || \URL::current() == route('admin.jurnal-umum.index')) show @endif
                "
                    aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item
                        @if (\URL::current() == route('admin.penjualan.index')) active @endif"
                        href="{{ route('admin.penjualan.index') }}">Penjualan</a>
                        <a class="collapse-item
                        @if (\URL::current() == route('admin.pembelian.index')) active @endif"
                        href="{{ route('admin.pembelian.index') }}">Pembelian</a>
                        <a class="collapse-item
                        @if (\URL::current() == route('admin.biaya.index')) active @endif"
                        href="{{ route('admin.biaya.index') }}">Biaya</a>
                        <a class="collapse-item
                        @if (\URL::current() == route('admin.jurnal-umum.index')) active @endif"
                        href="{{ route('admin.jurnal-umum.index') }}">Jurnal Umum</a>
                    </div>
                </div>
            </li>
            @endif

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporan"
                    aria-expanded="true" aria-controls="collapseLaporan">
                    <i class="fas fa-fw fa-file"></i>
                    <span>Laporan</span>
                </a>
                <div id="collapseLaporan" class="collapse
                @if (\URL::current() == route('admin.laporan.jurnalUmum') || \URL::current() == route('admin.laporan.arusKas') || \URL::current() == route('admin.laporan.bukuBesar') || \URL::current() == route('admin.laporan.neracaSaldo') || \URL::current() == route('admin.laporan.labaRugi')) show @endif
                "
                    aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item
                        @if (\URL::current() == route('admin.laporan.jurnalUmum')) active @endif"
                        href="{{ route('admin.laporan.jurnalUmum') }}">Jurnal Umum</a>
                        <a class="collapse-item
                        @if (\URL::current() == route('admin.laporan.bukuBesar')) active @endif"
                        href="{{ route('admin.laporan.bukuBesar') }}">Buku Besar</a>
                        <a class="collapse-item
                        @if (\URL::current() == route('admin.laporan.neracaSaldo')) active @endif"
                        href="{{ route('admin.laporan.neracaSaldo') }}">Neraca Saldo</a>
                        <a class="collapse-item
                        @if (\URL::current() == route('admin.laporan.labaRugi')) active @endif"
                        href="{{ route('admin.laporan.labaRugi') }}">Laba Rugi</a>
                        <a class="collapse-item
                        @if (\URL::current() == route('admin.laporan.arusKas')) active @endif"
                        href="{{ route('admin.laporan.arusKas') }}">Arus Kas</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow nav-radius">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>



                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                <div style="text-align: center; padding-top: 4px; background: #42689d;"
                                    class="img-profile rounded-circle text-white">{{ Auth::user()->getFirstChar() }}
                                </div>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Keluar
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('back_button')
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">@yield('title')</h1>
                    </div>

                    {{-- @include('layouts.include.breadcrumbs', ['title' => app()->view->getSections()['title']]) --}}
                    @if (\Session::has('success'))
                        <div class="row">
                            <div class="col-md-12">
                                <small>
                                    <div class="alert alert-success alert-dismissible fade show">
                                        {{ \Session::get('success') }}
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </small>
                            </div>
                        </div>
                    @endif
                    @if (\Session::has('info'))
                        <div class="row">
                            <div class="col-md-12">
                                <small>
                                    <div class="alert alert-info alert-dismissible fade show">
                                        {{ \Session::get('info') }}
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </small>
                            </div>
                        </div>
                    @endif
                    @if (\Session::has('error_msg'))
                        <div class="row">
                            <div class="col-md-12">
                                <small>
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        {{ \Session::get('error_msg') }}
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </small>
                            </div>
                        </div>
                    @endif
                    @if (count($errors) > 0)
                        <div class="row">
                            <div class="col-md-12">
                                <small>
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </small>
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; {{ env('APP_NAME') }} {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah anda yakin?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih <b>keluar</b> di bawah ini jika Anda siap untuk mengakhiri sesi Anda
                    saat ini.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                        Keluar
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/js/sb-admin-2.min.js"></script>
    <script src="/vendor/sweetalert/sweetalert.min.js"></script>
    @yield('script')
</body>
<script>
    $(document).ready(function() {

        width = document.documentElement.clientWidth;
        if (width < 768) {
            $('.sidebar').addClass('toggled');
        }

        $('#accordionSidebar li').each(function() {
            var current = window.location.href;
            var a = $(this).find('a').attr('href');

            if (a == current) {
                $(this).addClass('active');
            }

        });

        @if (\Session::has('success'))
            swal({
            title: "Sukses",
            text: "{{ \Session::get('success') }}",
            icon: "success"
            })
        @endif

        @if (\Session::has('error_msg'))
            swal({
                title: "Sukses",
                text: "{{ \Session::get('error_msg') }}",
                icon: 'error',
                title: 'Oops...',
            })
        @endif

    });
</script>

</html>

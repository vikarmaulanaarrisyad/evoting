<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $setting->nama_singkatan ?? $setting->nama_aplikasi ?? config('app.name') }} - @yield('title')</title>

    <link rel="icon" href="{{ asset('assets/logo/logo.jpg') }}" type="image/*">

    {{-- Animation css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/font-digital/SFDigitalReadout-HeavyObliq.ttf') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('/AdminLTE/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('/AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- SweetAler2 -->
    <link rel="stylesheet" href="{{ asset('/AdminLTE/plugins/sweetalert2/sweetalert2.min.css') }}">

    @stack('css_vendor')

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/AdminLTE/dist/css/adminlte.min.css') }}">

    <style>
        .element {
            visibility: hidden;
        }

        .animasi-teks {
            font-size: 16px;
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
            -webkit-animation: typing 5s steps(70, end);
            animation: animasi-ketik 5s steps(70, end);
        }



        .note-editor {
            margin-bottom: 0;
        }

        .note-editor.is-invalid {
            border-color: var(--danger);
        }

        .nav-sidebar .nav-header {
            font-size: .6rem;
            font-weight: bold;
            color: #888;
        }

        .help-block {
            display: block;
            margin-top: 5px;
            margin-bottom: 10px;
            color: red;
        }

        .form-control.has-error {
            border-radius: 0;
            box-shadow: none;
            border-color: #fb0000;
        }

        #background-loading {
            background: #07131e;
            z-index: 99999;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            position: fixed;
        }

        .loading-text {
            position: absolute;
            color: #fff;
            top: 50%;
            left: 50%;
            margin: -5px 0 0 -32px;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: 700;
        }

        .loader {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 120px;
            height: 120px;
            margin: -60px 0 0 -60px;
            border: 4px solid transparent;
            border-top-color: #ffa500;
            border-bottom-color: #ffa500;
            border-radius: 50%;
            animation: loading 2s linear;
            animation-iteration-count: infinite;
        }

        .loader::after,
        .loader::before {
            content: "";
            position: absolute;
            border-radius: 50%;
        }

        .loader::after {
            left: 15px;
            top: 15px;
            right: 15px;
            bottom: 15px;
            border: 3px solid transparent;
            border-top-color: #32cd32;
            border-bottom-color: #32cd32;
            animation: loading 1.5s linear;
            animation-iteration-count: infinite;
        }

        .loader::before {
            left: 6px;
            top: 6px;
            right: 6px;
            bottom: 6px;
            border: 3px solid transparent;
            border-top-color: #03afdb;
            border-bottom-color: #03afdb;
            animation: loading 3s linear;
            animation-iteration-count: infinite;
        }

        @import url('https://fonts.googleapis.com/css2?family=Digital+7&display=swap');

        #currentTime {
            font-family: 'Digital-7', sans-serif;
            /* Sesuaikan ukuran font sesuai kebutuhan */
        }

        @keyframes loading {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes animasi-ketik {
            from {
                width: 0;
            }
        }
    </style>

    @stack('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed"
    onload="displayCurrentTime()">

    <div class="wrapper">

        <!-- Navbar -->
        @includeIf('partials.header')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @includeIf('partials.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('header')</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                @section('breadcrumb')
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                                @show
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>

        <!-- /.content-wrapper -->
        @includeIf('partials.footer')

    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('/AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('/AdminLTE/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('/AdminLTE/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('/AdminLTE/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('/AdminLTE/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('/AdminLTE/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('/AdminLTE/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('/AdminLTE/plugins/moment/moment.min.js') }}"></script>

    <!-- overlayScrollbars -->
    <script src="{{ asset('/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- sweetalert2 -->
    <script src="{{ asset('/AdminLTE/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>

    @stack('scripts_vendor')

    <!-- AdminLTE App -->
    <script src="{{ asset('/AdminLTE/dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('/js/custom.js') }}"></script>

    @stack('scripts')

 {{-- <script>
        function animateElements() {
            var elements = document.querySelectorAll('.element');
            for (var i = 0; i < elements.length; i++) {
                var element = elements[i];
                element.style.visibility = 'visible';
                element.classList.add('animasi-teks', 'animasi-teks');
                setTimeout(function() {
                    element.classList.remove('animasi-teks', 'animasi-teks');
                }, 8000); // Hapus class animasi setelah 1 detik
            }
        }

        document.addEventListener("DOMContentLoaded", function(event) {
            animateElements();
            setInterval(animateElements, 5000); // Mengulangi setiap 5 detik
        });
    </script>

   <script>
        function displayCurrentTime() {
            var currentTime = new Date();
            var options = {
                timeZone: 'Asia/Jakarta',
                hour12: false
            };
            var timeString = currentTime.toLocaleTimeString('id-ID', options) + ' WIB';

            var timeElement = document.getElementById('currentTime');
            timeElement.textContent = timeString;
        }

        setInterval(displayCurrentTime, 1000); // Memperbarui waktu setiap detik
    </script> --}}


</body>

</html>

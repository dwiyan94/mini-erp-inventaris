<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Dashboard') | ERP Inventaris - Syailendra</title>

    <link href="{{ asset('inspinia/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('inspinia/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <!-- Toastr style -->
    <link href="{{ asset('inspinia/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

    <!-- Gritter -->
    <link href="{{ asset('inspinia/js/plugins/gritter/jquery.gritter.css') }}" rel="stylesheet">

    <link href="{{ asset('inspinia/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/style.css') }}" rel="stylesheet">

    <link href="{{ asset('inspinia/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">

    <link href="{{ asset('inspinia/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

    <link href="{{ asset('inspinia/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">

    <link href="{{ asset('inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">

    <link href="{{ asset('inspinia/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body>
    <div id="wrapper">
        
        <!-- Panggil Sidebar -->
        @include('layouts.sidebar')

        <div id="page-wrapper" class="gray-bg dashbard-1">
            
            <!-- Panggil Topbar / Navbar Atas -->
            @include('layouts.topbar')

            <!-- Konten Utama Halaman Berubah-ubah -->
            @yield('content')

            <!-- Panggil Footer -->
            @include('layouts.footer')

        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{asset('inspinia/js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('inspinia/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('inspinia/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{asset('inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

    <!-- Flot -->
    <script src="{{ asset('inspinia/js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/flot/jquery.flot.spline.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/flot/jquery.flot.pie.js') }}"></script>

    <!-- Peity -->
    <script src="{{ asset('inspinia/js/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('inspinia/js/demo/peity-demo.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('inspinia/js/inspinia.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/pace/pace.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('inspinia/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- GITTER -->
    <script src="{{ asset('inspinia/js/plugins/gritter/jquery.gritter.min.js') }}"></script>

    <!-- Sparkline -->
    <script src="{{ asset('inspinia/js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Sparkline demo data  -->
    <script src="{{ asset('inspinia/js/demo/sparkline-demo.js') }}"></script>

    <!-- ChartJS-->
    <script src="{{ asset('inspinia/js/plugins/chartJs/Chart.min.js') }}"></script>

    <!-- Toastr -->
    <script src="{{ asset('inspinia/js/plugins/toastr/toastr.min.js') }}"></script>

    <!-- Sweet alert -->
    <script src="{{ asset('inspinia/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Toastr script -->
    <script src="{{ asset('inspinia/js/plugins/toastr/toastr.min.js') }}"></script>

    <!-- Data picker -->
    <script src="{{ asset('inspinia/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

    <script src="{{ asset('inspinia/js/plugins/chosen/chosen.jquery.js') }}"></script>

    <script type="text/javascript">
        
        $(document).ready(function() {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "progressBar": true,
                "preventDuplicates": false,
                "positionClass": "toast-top-right",
                "showDuration": "400",
                "hideDuration": "1000",
                "timeOut": "4000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            @if(session('success'))
                toastr.success('{{ session('success') }}', 'Berhasil!');
            @endif

            @if(session('error'))
                toastr.error('{{ session('error') }}', 'Gagal!');
            @endif

            @if($errors->any())
                toastr.error('Terjadi kesalahan. Periksa kembali input data Anda.', 'Validasi Gagal!');
            @endif
        });

        function confirmDelete(id) {
            swal({
                title: "Apakah Anda yakin?",
                text: "Data departemen yang dihapus akan masuk ke sampah !",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function (isConfirm) {
                if (isConfirm) {
                    document.getElementById('delete-form-' + id).submit();
                    swal("Terhapus!", "Data yang anda pilih telah terhapus.", "success");
                } else {
                    swal("Batal", "Data yang akan dihapus dibatalkan :)", "error");
                }            
            });
        }
    </script>

    @stack('scripts')

    @yield('scripts')
</body>
</html>
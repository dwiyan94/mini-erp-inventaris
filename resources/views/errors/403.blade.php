<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden | ERP Inventaris</title>
    <link href="{{ asset('inspinia/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('inspinia/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/style.css') }}" rel="stylesheet">
</head>
<body class="gray-bg">
    <div class="middle-box text-center animated fadeInDown">
        <h1>403</h1>
        <h3 class="font-bold">Akses Ditolak (Forbidden)</h3>
        <div class="error-desc">
            Maaf, akun Anda tidak memiliki hak akses (*permission*) untuk membuka halaman atau melakukan tindakan ini. <br/>
            Silakan kembali ke halaman utama sistem.
            <form class="form-inline m-t" role="form">
                <a class="btn btn-primary" href="{{ route('dashboard') }}">Kembali ke Dashboard</a>
            </form>
        </div>
    </div>
</body>
</html>
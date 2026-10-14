<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | ERP Inventaris - Syailendra</title>
    <link href="{{ asset('inspinia/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('inspinia/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/style.css') }}" rel="stylesheet">
    <style>
        .login-card {
            background: #ffffff;
            padding: 35px 40px;
            border-radius: 8px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
            margin-top: 30px;
        }
        .login-logo {
            max-height: 200px; 
            max-width: 100%; 
            margin-bottom: 25px; 
            object-fit: contain;
        }
        .form-control {
            border-radius: 4px;
            height: 44px;
            padding: 10px 15px;
            background-color: #fcfcfc;
        }
        .form-control:focus {
            background-color: #ffffff;
            border-color: #1ab394;
        }
        .input-group-addon {
            background-color: #fcfcfc;
            border-color: #e5e6e7;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
        }
        .input-group-addon:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown" style="width: 440px; max-width: 100%;">
        <div class="login-card">
            <div>
                <img src="{{ asset('logo/logo.png') }}" alt="Logo Syailendra" class="login-logo">
            </div>
            <h3 class="font-bold" style="font-size: 20px; color: #2f4050; margin-bottom: 3px;">ERP INVENTARIS</h3>
            <p class="text-muted" style="font-size: 12px; margin-bottom: 25px;">PT. Syailendra Bumi Investama (DDistillers)</p>

            <form class="m-t" role="form" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group text-left @error('email') has-error @enderror">
                    <label class="font-normal text-muted"><small><strong>Alamat Email</strong></small></label>
                    <input type="email" name="email" class="form-control" placeholder="nama@syailendra.com" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group text-left @error('password') has-error @enderror" style="margin-top: 15px;">
                    <label class="font-normal text-muted"><small><strong>Password</strong></small></label>
                    <div class="input-group">
                        <input type="password" name="password" id="loginPassword" class="form-control" placeholder="••••••••" required style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                        <span class="input-group-addon" onclick="togglePasswordVisibility()" title="Lihat/Sembunyikan Password">
                            <i class="fa fa-eye" id="togglePasswordIcon" style="color: #676a6c;"></i>
                        </span>
                    </div>
                    @error('password')
                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group clearfix" style="margin-top: 15px; margin-bottom: 20px;">
                    <div class="checkbox pull-right" style="margin-top: 0;">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Ingat Saya
                        </label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary block full-width m-b" style="padding: 11px; font-weight: 600; border-radius: 4px; background-color: #1ab394; border-color: #1ab394;">Masuk Sistem</button>

                <div style="margin-top: 25px; border-top: 1px solid #e7eaec; padding-top: 20px;">
                    <p class="text-muted text-center" style="margin-bottom: 10px; font-size: 12px;">Belum memiliki akun ?</p>
                    <a class="btn btn-sm btn-white btn-block" href="{{ route('register') }}" style="border-radius: 4px; padding: 8px;">Buat Akun Baru</a>
                </div>
            </form>
        </div>
        
        <div style="margin-top: 25px;">
            <p class="text-muted"><small>Inspinia Web App Framework &copy; 2026</small></p>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('loginPassword');
            const passwordIcon = document.getElementById('togglePasswordIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash'); // Ubah ikon jadi mata dicoret
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye'); // Kembalikan jadi ikon mata biasa
            }
        }
    </script>
</body>
</html>
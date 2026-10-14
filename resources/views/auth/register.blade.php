<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | ERP Inventaris - Syailendra</title>
    <link href="{{ asset('inspinia/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('inspinia/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/style.css') }}" rel="stylesheet">
    <style>
        .login-card {
            background: #ffffff;
            padding: 40px 40px; 
            border-radius: 8px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .login-logo {
            max-height: 160px; 
            max-width: 100%; 
            margin-bottom: 20px; 
            object-fit: contain;
        }
        .form-control {
            border-radius: 4px;
            height: 42px;
            padding: 8px 15px;
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
    <div class="middle-box text-center loginscreen animated fadeInDown" style="width: 480px; max-width: 100%;">
        <div class="login-card">
            <div>
                <img src="{{ asset('logo/logo.png') }}" alt="Logo Syailendra" class="login-logo">
            </div>
            <h3 class="font-bold" style="font-size: 20px; color: #2f4050; margin-bottom: 3px;">PENGGUNA BARU</h3>
            <p class="text-muted" style="font-size: 12px; margin-bottom: 25px;">Daftar akun untuk mengakses ERP Inventaris</p>

            <form class="m-t" role="form" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group text-left @error('name') has-error @enderror">
                    <label class="font-normal text-muted"><small><strong>Nama Lengkap</strong></small></label>
                    <input type="text" name="name" class="form-control" placeholder="Nama Lengkap Anda" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group text-left @error('email') has-error @enderror" style="margin-top: 15px;">
                    <label class="font-normal text-muted"><small><strong>Alamat Email</strong></small></label>
                    <input type="email" name="email" class="form-control" placeholder="nama@syailendra.com" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group text-left @error('password') has-error @enderror" style="margin-top: 15px;">
                    <label class="font-normal text-muted"><small><strong>Password</strong></small></label>
                    <div class="input-group">
                        <input type="password" name="password" id="registerPassword" class="form-control" placeholder="Minimal 8 karakter" required style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                        <span class="input-group-addon" onclick="togglePasswordVisibility('registerPassword', 'togglePasswordIcon1')" title="Lihat/Sembunyikan Password">
                            <i class="fa fa-eye" id="togglePasswordIcon1" style="color: #676a6c;"></i>
                        </span>
                    </div>
                    @error('password')
                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group text-left" style="margin-top: 15px;">
                    <label class="font-normal text-muted"><small><strong>Konfirmasi Password</strong></small></label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="confirmPassword" class="form-control" placeholder="Ulangi password" required style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                        <span class="input-group-addon" onclick="togglePasswordVisibility('confirmPassword', 'togglePasswordIcon2')" title="Lihat/Sembunyikan Konfirmasi Password">
                            <i class="fa fa-eye" id="togglePasswordIcon2" style="color: #676a6c;"></i>
                        </span>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary block full-width m-b" style="padding: 11px; font-weight: 600; border-radius: 4px; background-color: #1ab394; border-color: #1ab394; margin-top: 20px;">Daftar Sekarang</button>

                <div style="margin-top: 25px; border-top: 1px solid #e7eaec; padding-top: 20px;">
                    <p class="text-muted text-center" style="margin-bottom: 10px; font-size: 12px;">Sudah memiliki akun?</p>
                    <a class="btn btn-sm btn-white btn-block" href="{{ route('login') }}" style="border-radius: 4px; padding: 8px;">Masuk ke Akun</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const passwordIcon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
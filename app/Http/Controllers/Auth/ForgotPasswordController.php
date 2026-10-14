<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResets;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | Controller ini bertanggung jawab untuk menangani email pengingat password
    | dan mengirimkan tautan reset ke pengguna.
    |
    */

    use SendsPasswordResets;

    // Menampilkan halaman form input email lupa password
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }
}
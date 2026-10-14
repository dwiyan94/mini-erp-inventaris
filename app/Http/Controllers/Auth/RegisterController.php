<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required', 
                'string', 
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
        ], [
            'password.mixed' => 'Password wajib mengandung kombinasi huruf besar dan huruf kecil.',
            'password.numbers' => 'Password wajib mengandung setidaknya satu buah angka.',
            'password.symbols' => 'Password wajib mengandung setidaknya satu buah simbol khusus.',
            'password.min' => 'Password minimal harus terdiri dari 8 karakter.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('employee');

        Auth::login($user);

        return redirect()->to('/dashboard')->with('success', 'Akun berhasil dibuat!');
    }
}
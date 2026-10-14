<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockMutationController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/profile', [UserController::class, 'profile'])->name('users.profile');
});

Route::middleware(['auth', 'permission:view-users'])->group(function () {
    Route::resource('users', UserController::class)->except(['create', 'edit']);
});

Route::middleware(['auth', 'permission:view-roles'])->group(function () {
    Route::resource('roles', RoleController::class)->except(['create', 'edit']);
});

// 3. Rute Modul Lainnya (Lindungi sesuai permission masing-masing)
Route::middleware(['auth', 'permission:view-departments'])->group(function () {
    Route::resource('departments', DepartmentController::class)->except(['create', 'edit']);
});

Route::middleware(['auth', 'permission:view-positions'])->group(function () {
    Route::resource('positions', PositionController::class)->except(['create', 'edit']);
});

Route::middleware(['auth', 'permission:view-employees'])->group(function () {
    Route::resource('employees', EmployeeController::class);
});

Route::middleware(['permission:view-stock_mutations'])->group(function () {
    Route::resource('stock_mutations', StockMutationController::class)->only(['index', 'store']);

    Route::get('/stock-mutations/{id}', [StockMutationController::class, 'show'])->name('stock_mutations.show');
});

Route::middleware(['auth', \App\Http\Middleware\CheckSingleSession::class, 'permission:view-products'])->group(function () {
    Route::get('/products/import-demo', [ProductController::class, 'importDemo'])->name('products.import-demo');
    Route::get('/products/reset-demo', [ProductController::class, 'resetDemo'])->name('products.reset-demo');

    Route::resource('products', ProductController::class)->except(['create', 'edit']);
});


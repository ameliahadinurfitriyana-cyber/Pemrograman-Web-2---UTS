<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Kasir\KasirTransactionController;
use Illuminate\Support\Facades\Route;

// OTP Registration Routes
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/send-otp', [RegisterController::class, 'sendOTP']);
Route::post('/verify-otp', [RegisterController::class, 'verifyOTP']);
Route::get('/register/data', [RegisterController::class, 'showDataForm'])->name('register.data');
Route::post('/register/data', [RegisterController::class, 'storeData'])->name('register.data.store');

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Category Management
    Route::resource('categories', CategoryController::class);

    // User Management
    Route::get('/admin/users', [AdminController::class, 'usersIndex'])->name('admin.users.index');
    Route::get('/admin/users/create', [AdminController::class, 'usersCreate'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'usersStore'])->name('admin.users.store');
    Route::get('/admin/users/{user}', [AdminController::class, 'usersShow'])->name('admin.users.show');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'usersEdit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminController::class, 'usersUpdate'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'usersDestroy'])->name('admin.users.destroy');

    // Customer Management
    Route::get('/admin/customers', [AdminController::class, 'customersIndex'])->name('admin.customers.index');
    Route::get('/admin/customers/create', [AdminController::class, 'customersCreate'])->name('admin.customers.create');
    Route::post('/admin/customers', [AdminController::class, 'customersStore'])->name('admin.customers.store');
    Route::get('/admin/customers/{customer}/edit', [AdminController::class, 'customersEdit'])->name('admin.customers.edit');
    Route::put('/admin/customers/{customer}', [AdminController::class, 'customersUpdate'])->name('admin.customers.update');
    Route::delete('/admin/customers/{customer}', [AdminController::class, 'customersDestroy'])->name('admin.customers.destroy');

    // Product Management
    Route::get('/admin/products', [AdminController::class, 'productsIndex'])->name('admin.products.index');
    Route::get('/admin/products/create', [AdminController::class, 'productsCreate'])->name('admin.products.create');
    Route::post('/admin/products', [AdminController::class, 'productsStore'])->name('admin.products.store');
    Route::get('/admin/products/{product}/edit', [AdminController::class, 'productsEdit'])->name('admin.products.edit');
    Route::put('/admin/products/{product}', [AdminController::class, 'productsUpdate'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [AdminController::class, 'productsDestroy'])->name('admin.products.destroy');

    // Transaction Management
    Route::get('/admin/transactions', [AdminController::class, 'transactionsIndex'])->name('admin.transactions.index');
    Route::get('/admin/transactions/create', [AdminController::class, 'transactionsCreate'])->name('admin.transactions.create');
    Route::post('/admin/transactions', [AdminController::class, 'transactionsStore'])->name('admin.transactions.store');
    Route::get('/admin/transactions/{transaction}', [AdminController::class, 'transactionsShow'])->name('admin.transactions.show');
    Route::delete('/admin/transactions/{transaction}', [AdminController::class, 'transactionsDestroy'])->name('admin.transactions.destroy');

    // Reports
    Route::get('/admin/reports', [AdminController::class, 'reportsIndex'])->name('admin.reports.index');
});

Route::middleware(['auth', 'kasir'])->group(function () {
    Route::get('/kasir/transactions', [KasirTransactionController::class, 'index'])->name('kasir.transactions.index');
    Route::get('/kasir/transactions/create', [KasirTransactionController::class, 'create'])->name('kasir.transactions.create');
    Route::post('/kasir/transactions', [KasirTransactionController::class, 'store'])->name('kasir.transactions.store');
    Route::get('/kasir/transactions/{transaction}', [KasirTransactionController::class, 'show'])->name('kasir.transactions.show');
    Route::get('/kasir/transactions/{transaction}/print', [KasirTransactionController::class, 'print'])->name('kasir.transactions.print');
    Route::delete('/kasir/transactions/{transaction}', [KasirTransactionController::class, 'destroy'])->name('kasir.transactions.destroy');
    Route::get('/kasir/customers', [\App\Http\Controllers\Kasir\KasirCustomerController::class, 'index'])->name('kasir.customers.index');
});



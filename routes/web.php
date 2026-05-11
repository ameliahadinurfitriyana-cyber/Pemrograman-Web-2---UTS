<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Kasir\KasirReportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user?->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($user?->role === 'kasir') {
        return redirect()->route('kasir.dashboard');
    }

    return view('dashboard', [
        'user' => $user,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'kasir'])->group(function () {
    Route::get('/kasir/dashboard', function () {
        return view('dashboard', [
            'user' => Auth::user(),
        ]);
    })->name('kasir.dashboard');

    Route::get('/kasir/reports', [KasirReportController::class, 'index'])->name('kasir.reports.index');
});


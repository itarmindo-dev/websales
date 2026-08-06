<?php

use App\Http\Controllers\Admin\SalesProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TcoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/sales/{slug}', [PageController::class, 'salesProfile'])->name('sales.profile');
Route::post('/tco/submit', [TcoController::class, 'submit'])
    ->middleware('throttle:5,1')
    ->name('tco.submit');

Route::middleware(['auth', 'can:access-admin'])->group(function () {
    Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
    Route::resource('admin/sales', SalesProfileController::class)
        ->except('show')
        ->names('admin.sales');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

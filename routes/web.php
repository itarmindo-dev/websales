<?php

use App\Http\Controllers\Admin\LandingPageController;
use App\Http\Controllers\Admin\SalesProfileController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\TruckModelController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Sales\SelfProfileController;
use App\Http\Controllers\TcoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/sales/{slug}', [PageController::class, 'salesProfile'])->name('sales.profile');
Route::post('/tco/submit', [TcoController::class, 'submit'])
    ->middleware('throttle:5,1')
    ->name('tco.submit');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('can:access-sales')->group(function () {
        Route::get('/profil-sales-saya', [SelfProfileController::class, 'edit'])->name('sales.self.edit');
        Route::patch('/profil-sales-saya', [SelfProfileController::class, 'update'])->name('sales.self.update');
    });
});

Route::middleware(['auth', 'can:access-admin'])->group(function () {
    Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
    Route::resource('admin/sales', SalesProfileController::class)
        ->except('show')
        ->names('admin.sales');
    Route::get('admin/landing-page', [LandingPageController::class, 'edit'])->name('admin.landing.edit');
    Route::patch('admin/landing-page', [LandingPageController::class, 'update'])->name('admin.landing.update');
    Route::resource('admin/truck-models', TruckModelController::class)
        ->except('show')
        ->names('admin.truck-models');
    Route::resource('admin/testimonials', TestimonialController::class)
        ->except('show')
        ->names('admin.testimonials');
});

require __DIR__.'/auth.php';

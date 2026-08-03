<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PageController;
use App\Http\Controllers\TcoController;
use App\Http\Controllers\Admin\SalesProfileController;

Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/sales/{slug}', [PageController::class, 'salesProfile'])->name('sales.profile');
Route::post('/tco/submit', [TcoController::class, 'submit'])->name('tco.submit')->middleware('throttle:5,1');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('admin/sales', SalesProfileController::class)->names('admin.sales');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Fallback dummy routes for template links
Route::get('/any/{slug?}', function () { return redirect('/'); })->name('any');
Route::get('/second/{slug1?}/{slug2?}', function () { return redirect('/'); })->name('second');

require __DIR__.'/auth.php';

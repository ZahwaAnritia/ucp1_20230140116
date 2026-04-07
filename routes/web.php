<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    // Route Profile & About
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/about', [AboutController::class, 'index'])->name('about');

    // Route Product (Index & Show bisa diakses semua yang login)
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    
    // PENTING: /product/create HARUS DI ATAS /product/{id}
    Route::middleware('can:manage-product')->group(function () {
        Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    });

    // Route Detail (Pindahkan ke bawah create)
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

    // Route Edit & Delete (Sudah aman karena polanya berbeda)
    Route::get('/product/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');

});

require __DIR__.'/auth.php';
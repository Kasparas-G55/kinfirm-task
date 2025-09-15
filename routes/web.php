<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('/products', [ProductController::class, 'index'])->middleware(['auth', 'verified'])->name('product.index');
Route::get('/products/{sku}', [ProductController::class, 'show'])->middleware(['auth', 'verified'])->name('product.show');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('product.index');
Route::get('/products/{sku}', [ProductController::class, 'show'])->name('product.show');

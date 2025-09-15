<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Products/Index', [
            'products' => Product::get(),
            'tags' => Product::tags()
        ]);
    }

    public function show(string $sku)
    {
        return Inertia::render('Products/Show', [
            'product' => Product::with('stocks')->where('sku', '=', $sku)->firstOrFail()
        ]);
    }
}

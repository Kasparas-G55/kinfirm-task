<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
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

        $cacheKey = "product:{$sku}";

        $product = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($sku) {
            return Product::where('sku', '=', $sku)->firstOrFail();
        });

        $product->load('stocks');

        return Inertia::render('Products/Show', [
            'product' => $product
        ]);
    }
}

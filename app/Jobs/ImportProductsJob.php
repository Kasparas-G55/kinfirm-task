<?php

namespace App\Jobs;

use App\Models\Product;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImportProductsJob implements ShouldQueue
{
    use Queueable;

    protected $endpoint;

    /**
     * Create a new job instance.
     */
    public function __construct(string $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        Log::info('Trying to get products from external endpoint...');
        $response = Http::get($this->endpoint);

        if ($response->failed())
            throw new Exception("API Response failed with code: {$response->status()}");

        $products = $response->json();
        $skuArray = collect($products)->pluck('sku')->toArray();

        // Since this is a command, single record inserts are fine for now.
        Log::info('Inserting products...');
        foreach ($products as $product)
            Product::updateOrCreate(['sku' => $product['sku']], $product);

        Log::info('Deleting outdated products...');
        $deletedCount = Product::whereNotIn('sku', $skuArray)->delete();
        Log::info("Deleted {$deletedCount} products.");
    }
}

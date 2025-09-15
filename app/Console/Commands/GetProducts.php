<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

use function Pest\Laravel\json;

class GetProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve products from an endpoint and store them inside the database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Trying to get products from external endpoint...');
        $response = Http::get('https://kinfirm.com/app/uploads/laravel-task/products.json');

        if ($response->failed())
            $this->error("Failed to retrieve products. (Status: {$response->status()})");

        $products = $response->json();
        $skuArray = collect($products)->pluck('sku')->toArray();

        $this->info('Inserting products...');
        // Since this is a command, single record inserts are fine for now.
        foreach ($products as $product)
            Product::updateOrCreate(['sku' => $product['sku']], $product);

        $this->info('Deleting outdated products...');
        $deletedCount = Product::whereNotIn('sku', $skuArray)->delete();
        $this->info("Deleted {$deletedCount} products.");

        $this->info('Successfully retrieved products.');
    }
}

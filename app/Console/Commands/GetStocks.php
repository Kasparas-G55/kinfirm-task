<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetStocks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync:stocks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Trying to get stocks from external endpoint...');
        $response = Http::get('https://kinfirm.com/app/uploads/laravel-task/stocks.json');

        if ($response->failed())
            $this->error("Failed to retrieve stocks. (Status: {$response->status()})");

        $stocks = $response->collect();

        $products = Product::pluck('sku')->toArray();

        // Filtering out stocks for products that don't exist.
        $validStocks = $stocks->filter(function ($stock) use ($products) {
            return in_array($stock['sku'], $products);
        })->toArray();

        $this->info('Upserting new stocks...');
        Stock::upsert($validStocks, ['sku', 'city'], ['stock']);

        $this->info('Successfully retrieved stocks.');
    }
}

<?php

namespace App\Console\Commands;

use App\Jobs\ImportProductsJob;
use Illuminate\Console\Command;

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

        ImportProductsJob::dispatch('https://kinfirm.com/app/uploads/laravel-task/products.json');

        $this->info('Dispatched import products job.');
    }
}

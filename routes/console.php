<?php

use App\Console\Commands\GetStocks;
use Illuminate\Support\Facades\Schedule;

Schedule::command(GetStocks::class)->everyFifteenMinutes();

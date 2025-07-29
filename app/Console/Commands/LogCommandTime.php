<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class LogCommandTime extends Command
{
    protected $signature = 'custom:log-time';
    protected $description = 'Log the execution time of this command';

    public function handle(): void
    {
        Log::info("LogCommandTime finished at: " . now());
    }
}

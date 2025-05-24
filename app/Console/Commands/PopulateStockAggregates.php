<?php

namespace App\Console\Commands;

use App\Jobs\ProcessCompanyStockAggregate;
use Illuminate\Console\Command;
use App\Models\Stock;
use Carbon\Carbon;

class PopulateStockAggregates extends Command
{
    protected $signature = 'stocks:aggregate';
    protected $description = 'Queue jobs to aggregate stock data';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Queueing stock aggregation jobs...");

        $periods = [
            '1D' => Carbon::now()->subDay(),
            '1M' => Carbon::now()->subMonth(),
            '3M' => Carbon::now()->subMonths(3),
            '6M' => Carbon::now()->subMonths(6),
            'YTD' => Carbon::now()->startOfYear(),
            '1Y' => Carbon::now()->subYear(),
            '3Y' => Carbon::now()->subYears(3),
            '5Y' => Carbon::now()->subYears(5),
            '10Y' => Carbon::now()->subYears(10),
            'MAX' => null,
        ];

        // Process in chunks to reduce memory usage
        Stock::select('company_name')
            ->distinct()
            ->orderBy('company_name')
            ->chunk(100, function ($companies) use ($periods) {
                foreach ($companies as $company) {
                    ProcessCompanyStockAggregate::dispatch($company->company_name, $periods)
                        ->onQueue('stock-aggregate');

                    $this->info("Queued: " . $company->company_name);
                }
            });

        $this->info("All stock aggregation jobs have been queued.");
    }
}

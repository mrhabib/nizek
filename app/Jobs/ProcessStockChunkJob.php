<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Strategies\StockExcelImportStrategy;
use App\Services\StockService;
use App\Repositories\StockRepository;
use Illuminate\Support\Facades\Log;

class ProcessStockChunkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public array $chunk, public string $company) {}

    public function handle()
    {
        $service = new StockService(new StockRepository());
        $strategy = new StockExcelImportStrategy($service);

        foreach ($this->chunk as $row) {
            $strategy->handleRow([
                'company_name' => $this->company,
                'stock_value' => $row['stock_price'] ?? null,
                'recorded_at' => $row['date'] ?? null,
            ]);
        }
    }
}

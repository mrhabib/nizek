<?php

namespace App\Jobs;

use App\Imports\GenericExcelImport;
use App\Strategies\StockExcelImportStrategy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ProcessStockFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $path) {}

    public function handle(): void
    {
        $strategy = app(StockExcelImportStrategy::class);
        $fullPath = storage_path("app/{$this->path}");
        Excel::import(new GenericExcelImport($strategy), $fullPath);

    }
}

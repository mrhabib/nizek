<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ChunkedStockImport;

class StartStockImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public string $path, public string $company) {}

    public function handle()
    {
        Log::info(' StartStockImportJob triggered with file: ' . $this->path);

        $fullPath = storage_path("app/{$this->path}");
        Excel::queueImport(new ChunkedStockImport($this->company), storage_path("app/{$this->path}"));

    }
}

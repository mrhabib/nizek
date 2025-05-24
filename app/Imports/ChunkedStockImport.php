<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use App\Jobs\ProcessStockChunkJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ChunkedStockImport implements ToCollection, WithChunkReading , ShouldQueue , WithHeadingRow
{
    protected string $company;

    public function __construct(string $company)
    {
        $this->company = $company;
    }

    public function collection(Collection $rows)
    {
        ProcessStockChunkJob::dispatch($rows->toArray(), $this->company);
    }

    public function chunkSize(): int
    {
        return 100;
    }
}

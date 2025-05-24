<?php

namespace App\Strategies;

use App\Services\StockServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StockExcelImportStrategy implements ExcelImportStrategyInterface
{
    public function __construct(protected StockServiceInterface $service) {}

    public function handleRow(array $row): void
    {
        if (empty($row['recorded_at']) || empty($row['stock_value'])) {
            Log::warning("Skipping invalid row: " . json_encode($row));
            return;
        }

        $this->service->import([
            'company_name' => $row['company_name'] ?? 'Unknown',
            'stock_value' => $row['stock_value'],
            'recorded_at' => is_numeric($row['recorded_at'])
                ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['recorded_at'])
                : \Carbon\Carbon::parse($row['recorded_at']),
        ]);
    }
}

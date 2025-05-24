<?php

namespace App\Services;

use App\Jobs\StartStockImportJob;
use App\Models\Stock;
use App\Repositories\StockRepositoryInterface;
use App\Models\StockAggregate;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StockService implements StockServiceInterface
{
    protected array $buffer = [];
    protected int $chunkSize = 1000;

    public function __construct(protected StockRepositoryInterface $repository) {}

    public function storeStockFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        $filename = uniqid() . '.' . $request->file('file')->getClientOriginalExtension();
        $path = $request->file('file')->storeAs('uploads', $filename);

        StartStockImportJob::dispatch("private/uploads/{$filename}", auth()->user()->company ?? 'Unknown');

        return [
            'message' => 'File uploaded successfully. Processing started.'
        ];
    }

    public function import(array $data): void
    {
        $this->buffer[] = $data;

        if (count($this->buffer) >= $this->chunkSize) {
            $this->flush();
        }
    }

    public function __destruct()
    {
        $this->flush();
    }

    protected function flush(): void
    {
        if (!empty($this->buffer)) {
            $this->repository->bulkInsert($this->buffer);
            $this->buffer = [];
        }
    }
    public function getStockChanges(string $company_name)
    {
        $cacheKey = "stock_changes:$company_name";

        $aggregatesArray = Cache::remember($cacheKey, now()->addMinutes(10), function() use ($company_name) {
            return StockAggregate::where('company_name', $company_name)
                ->get()
                ->toArray();
        });

        if (empty($aggregatesArray)) {
            return null;
        }

        return collect($aggregatesArray);
    }
    public function getStockChangeBetweenDates(string $company_name, string $start_date, string $end_date)
    {
        $cacheKey = "stock_change_custom:{$company_name}:{$start_date}:{$end_date}";

        return Cache::remember($cacheKey, now()->addMinutes(10), function() use ($company_name, $start_date, $end_date) {
            $startDate = Carbon::parse($start_date);
            $endDate = Carbon::parse($end_date);

            $startRecord = Stock::where('company_name', $company_name)
                ->where('recorded_at', '<=', $startDate)
                ->orderByDesc('recorded_at')
                ->first();

            $endRecord = Stock::where('company_name', $company_name)
                ->where('recorded_at', '<=', $endDate)
                ->orderByDesc('recorded_at')
                ->first();

            if (!$startRecord || !$endRecord) {
                return null;
            }

            $change = (($endRecord->stock_value - $startRecord->stock_value) / $startRecord->stock_value) * 100;

            return [
                'company' => $company_name,
                'start_date' => $startDate->toDateString(),
                'start_value' => $startRecord->stock_value,
                'end_date' => $endDate->toDateString(),
                'end_value' => $endRecord->stock_value,
                'percentage_change' => round($change, 2),
            ];
        });
    }




}

<?php

namespace App\Jobs;

use App\Models\Stock;
use App\Models\StockAggregate;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCompanyStockAggregate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $company_name;
    protected $periods;

    public function __construct($company_name, $periods)
    {
        $this->company_name = $company_name;
        $this->periods = $periods;
    }

    public function handle()
    {
        $current = Stock::where('company_name', $this->company_name)
            ->latest('recorded_at')
            ->first();

        if (!$current) return;

        foreach ($this->periods as $label => $startDate) {
            $query = Stock::where('company_name', $this->company_name);
            if ($startDate) {
                $query->where('recorded_at', '<=', $startDate);
            }
            $old = $query->orderByDesc('recorded_at')->first();

            if ($old) {
                StockAggregate::updateOrCreate(
                    ['company_name' => $this->company_name, 'period' => $label],
                    [
                        'start_value' => $old->stock_value,
                        'end_value' => $current->stock_value,
                        'start_date' => $old->recorded_at,
                        'end_date' => $current->recorded_at,
                    ]
                );
            }
        }
    }
}

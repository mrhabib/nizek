<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomDateChangeRequest;
use App\Http\Requests\StockChangeRequest;
use App\Http\Resources\CustomDateChangeResource;
use App\Http\Resources\StockChangeCollection;
use App\Services\StockService;

class StockController extends Controller
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function getStockChanges(StockChangeRequest $request)
    {
        $company_name = $request->input('company_name');

        $aggregates = $this->stockService->getStockChanges($company_name);

        if (!$aggregates) {
            return response()->json(['error' => 'No data for company.'], 404);
        }

        return new StockChangeCollection($aggregates);

    }

    public function getStockChangeBetweenDates(CustomDateChangeRequest $request)
    {
        $company_name = $request->input('company_name');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $result = $this->stockService->getStockChangeBetweenDates($company_name, $start_date, $end_date);

        if (!$result) {
            return response()->json(['error' => 'No data for given company or dates.'], 404);
        }

        return new CustomDateChangeResource((object)$result);
    }
}

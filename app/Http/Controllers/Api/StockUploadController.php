<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StockService;
use Illuminate\Http\Request;

class StockUploadController extends Controller
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }
    public function store(Request $request)
    {
        $result = $this->stockService->storeStockFile($request);
        return response()->json($result);
    }
}

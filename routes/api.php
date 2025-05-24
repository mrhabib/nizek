<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StockUploadController;
use App\Http\Controllers\Api\StockController;

Route::post('/upload', [StockUploadController::class, 'store']);
Route::get('/stock/{company_name}/changes', [StockController::class, 'getStockChanges']);
Route::get('/stock/{company_name}/changes/custom', [StockController::class, 'getStockChangeBetweenDates']);



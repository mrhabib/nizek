<?php

namespace App\Services;

interface StockServiceInterface
{
    public function import(array $data): void;
}

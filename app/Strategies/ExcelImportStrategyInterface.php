<?php

namespace App\Strategies;

interface ExcelImportStrategyInterface
{
    public function handleRow(array $row): void;
}
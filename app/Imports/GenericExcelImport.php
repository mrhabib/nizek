<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Strategies\ExcelImportStrategyInterface;

class GenericExcelImport implements ToCollection
{
    public function __construct(protected ExcelImportStrategyInterface $strategy) {}

    public function collection(Collection $collection): void
    {
        foreach ($collection as $row) {
            $this->strategy->handleRow($row->toArray());
        }
    }
}

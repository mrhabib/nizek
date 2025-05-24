<?php

namespace App\Repositories;

use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class StockRepository implements StockRepositoryInterface
{
    public function create(array $data): void
    {
        Stock::create($data);
    }

    public function bulkInsert(array $rows): void
    {
        DB::table('stocks')->insert($rows);
    }

}

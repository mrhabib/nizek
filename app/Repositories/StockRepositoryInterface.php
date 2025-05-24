<?php

namespace App\Repositories;

interface StockRepositoryInterface
{
    public function create(array $data): void;
    public function bulkInsert(array $rows): void;

}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StockChangeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        $company_name = optional($this->collection->first())['company_name'] ?? null;

        $changes = [];
        foreach ($this->collection as $agg) {
            $change = (($agg['end_value'] - $agg['start_value']) / $agg['start_value']) * 100;
            $changes[$agg['period']] = round($change, 2);
        }

        return [
            'company' => $company_name,
            'changes' => $changes,
        ];
    }
}

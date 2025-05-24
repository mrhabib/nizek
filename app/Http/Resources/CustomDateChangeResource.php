<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomDateChangeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'company' => $this->company,
            'start_date' => $this->start_date,
            'start_value' => round($this->start_value, 2),
            'end_date' => $this->end_date,
            'end_value' => round($this->end_value, 2),
            'percentage_change' => round($this->percentage_change, 2),
        ];
    }
}

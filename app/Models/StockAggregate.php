<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockAggregate extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'period',
        'start_value',
        'end_value',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'start_value' => 'float',
        'end_value' => 'float',
    ];

    public $timestamps = true;
}

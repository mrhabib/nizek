<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'stock_value',
        'recorded_at',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
        'stock_value' => 'float',
    ];
    public $timestamps = true;
}

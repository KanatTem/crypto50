<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CryptoCurrency extends Model
{
    protected $fillable = [
        'name',
        'symbol',
        'price_usd',
        'change_24h',
        'market_cap',
        'volume_24h',
        'sparkline',
    ];

    protected $casts = [
        'sparkline' => 'array',
        'price_usd' => 'float',
        'change_24h' => 'float',
        'market_cap' => 'float',
        'volume_24h' => 'float',
    ];
}

<?php

namespace App\Http\Controllers;

use App\Models\CryptoCurrency;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CryptoController extends Controller
{
    public function index() : View
    {
        $cryptos = CryptoCurrency::orderByDesc('market_cap')->get();

        return view('crypto.index', compact('cryptos'));
    }

    public function show(string $symbol)
    {
        $crypto = CryptoCurrency::where('symbol', strtoupper($symbol))->firstOrFail();

        return view('crypto.show', compact('crypto'));
    }

}

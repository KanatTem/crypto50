<?php

use App\Http\Controllers\CryptoController;
use Illuminate\Support\Facades\Route;


/*Route::get('/', function () {
    return view('welcome');
});
*/


Route::get('/', [CryptoController::class, 'index']);
Route::get('/{symbol}', [CryptoController::class, 'show'])->name('crypto.show');



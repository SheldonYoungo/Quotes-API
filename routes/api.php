<?php

use App\Http\Controllers\QuotesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:api')->group(function () {

    Route::get('/quote', [QuotesController::class, 'getAllQuotes']);
    Route::get('/quote/random', [QuotesController::class, 'getRandomQuote']);
    Route::get('/quote/{id}', [QuotesController::class, 'getQuote']);

});
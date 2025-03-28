<?php

namespace QuotesApiPackage;

use QuotesApiPackage\Http\Controllers\QuotesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:api')->group(function () {

    Route::get('/api/quote', [QuotesController::class, 'getAllQuotes']);
    Route::get('/api/quote/random', [QuotesController::class, 'getRandomQuote']);
    Route::get('/api/quote/{id}', [QuotesController::class, 'getQuote']);

});
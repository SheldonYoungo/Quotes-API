<?php

namespace QuotesApiPackage;

use Illuminate\Support\Facades\Route;

Route::get('/quotes-ui', function () {
    return view('quotes-api-package::quotes');
});

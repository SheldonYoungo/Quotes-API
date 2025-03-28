<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Mockery;
use QuotesApiPackage\Http\Controllers\QuotesController;
use QuotesApiPackage\Services\QuoteService;

// Prueba de controlador para obtener todas las quotes

it('retrieves all quotes', function () {
    
    $mockQuotesService = Mockery::mock(QuoteService::class)
        ->shouldReceive('getAllQuotes')
        ->andReturn([
            'quotes' => [], 
            'total' => 0, 
            'limit' => 10, 
            'skip' => 0
        ])
        ->getMock();

    $controller = new QuotesController($mockQuotesService);

    $request = Request::create('/api/quote', 'GET', ['limit' => 10, 'skip' => 0]);

    Http::fake([
        '*' => Http::response(['quotes' => [], 'total' => 0, 'limit' => 10, 'skip' => 0], 200)
    ]);

    $response = $controller->getAllQuotes($request);

    expect($response->getStatusCode())->toBe(200);

    expect($response->getData())->toBeObject()
        ->toHaveKeys(['quotes', 'total', 'limit', 'skip']);
});
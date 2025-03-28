<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Http;
use Mockery;
use QuotesApiPackage\Http\Controllers\QuotesController;
use QuotesApiPackage\Services\QuoteService;

// Prueba de controlador para obtener una quote aleatoria

it('retrieves a random quote', function () {
    $mockQuotesService = Mockery::mock(QuoteService::class)
        ->shouldReceive('getRandomQuote')
        ->andReturn([
            'id' => 1, 
            'quote' => 'Test quote',
            'author' => 'Test author' 
        ])
        ->getMock();
        
    $controller = new QuotesController($mockQuotesService);

    Http::fake([
        '*' => Http::response(['id' => 1, 'quote' => 'Test quote', 'author' => 'Test author'], 200)
    ]);

    $response = $controller->getRandomQuote();

    expect($response->getStatusCode())->toBe(200);

    expect($response->getData())->toBeObject()
        ->toHaveKeys(['id', 'quote', 'author']);
});
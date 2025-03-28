<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use Mockery;
use QuotesApiPackage\Http\Controllers\QuotesController;
use QuotesApiPackage\Services\QuoteService;

// Prueba de controlador para obtener una quote específica

it('retrieves a specific quote', function () {
    $mockQuotesService = Mockery::mock(QuoteService::class)
        ->shouldReceive('getQuote')
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

    $response = $controller->getQuote(1);
    $responseData = $response->getData(true);

    expect($responseData)->toBeArray()
        ->toHaveKeys(['id', 'quote', 'author']);
});

it('returns an error for an invalid quote ID', function () {
    $mockQuotesService = Mockery::mock(QuoteService::class)
        ->shouldReceive('getQuote')
        ->with(-1)
        ->andThrow(new \InvalidArgumentException('Index not valid. The value must be an positive integer greater than zero.'))
        ->getMock();

    $controller = new QuotesController($mockQuotesService);

    $response = $controller->getQuote(-1);

    expect($response)->toBeInstanceOf(JsonResponse::class)
        ->and($response->getStatusCode())->toBe(400)
        ->and($response->getData(true))->toMatchArray([
            'error' => 'Index not valid. The value must be an positive integer greater than zero.'
        ]);
});
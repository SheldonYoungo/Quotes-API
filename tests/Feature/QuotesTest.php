<?php

namespace Tests\Feature;

use Http;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Testing\Fluent\AssertableJson;
use QuotesApiPackage\Services\QuoteService;
use RuntimeException;


it('retrieves all quotes via dummmyjson API', function () {
    $quoteService = app(QuoteService::class);
    $response = $quoteService->getAllQuotes();

    expect($response)->toBeArray()
        ->toHaveKeys(['quotes', 'total', 'skip', 'limit']);
});

it('retrieves a random quote via dummmyjson API', function () {
    $quoteService = app(QuoteService::class);
    $response = $quoteService->getRandomQuote();

    expect($response)->toBeArray()
        ->toHaveKeys(['id', 'quote', 'author']);

});

it('retrieves a specific quote via dummmyjson API', function () {
    $quoteService = app(QuoteService::class);
    $response = $quoteService->getQuote(1);

    expect($response)->toBeArray()
        ->toHaveKeys(['id', 'quote', 'author']);
});

it('return the Vue.js UI view', function () {
    
    $this->withoutVite();
    $response = $this->get('/quotes-ui');
        
    $response->assertStatus(200);
    $response->assertViewIs('quotes-api-package::quotes');
    $response->assertSee('<div id="app" class="container mx-auto p-4">', false);
    $response->assertSee('<quotes>', false);
});

it('handles connection errors', function () {
    Http::fake(function() {
        throw new ConnectionException();
        });

    $quoteService = app(QuoteService::class);

    $this->expectException(ConnectionException::class);
    $this->expectExceptionMessage('An error occurred while fetching the quotes. Please try again later.');

    $quoteService->getAllQuotes();
    $quoteService->getRandomQuote();
    $quoteService->getQuote(1);
});
<?php

namespace Tests\Unit;

use App\Http\Controllers\QuotesController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class RandomQuoteTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_get_random_quote()
    {
        $controller = new QuotesController();

        Http::fake([
            '*' => Http::response(['id' => 1, 'quote' => 'Test quote', 'author' => 'Test author'], 200)
        ]);

        $response = $controller->getRandomQuote();

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('quote', $response);
        $this->assertArrayHasKey('author', $response);
    }
}

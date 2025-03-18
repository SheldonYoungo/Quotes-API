<?php

namespace Tests\Unit;

use App\Http\Controllers\QuotesController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class GetQuoteTest extends TestCase
{
    public function test_get_quote()
    {
        $controller = new QuotesController();

        Http::fake([
            '*' => Http::response(['id' => 1, 'quote' => 'Test quote', 'author' => 'Test author'], 200)
        ]);

        $response = $controller->getQuote(1);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('quote', $response);
        $this->assertArrayHasKey('author', $response);
    }

    public function test_get_quote_with_invalid_id()
    {
        $controller = new QuotesController();

        $response = $controller->getQuote(-1);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(400, $response->status());
        $this->assertEquals(['error' => 'Index not valid. The value must be an positive integer greater than zero.'], $response->getData(true));
    }


}

<?php

namespace Tests\Unit;

use App\Http\Controllers\QuotesController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AllQuotesTest extends TestCase
{

    #[Test]
    public function get_all_quotes_test(): void
    {
        $controller = new QuotesController();
        $request = Request::create('/api/quote', 'GET', ['limit' => 10, 'skip' => 0]);

        Http::fake([
            '*' => Http::response(['quotes' => [], 'total' => 0, 'limit' => 10, 'skip' => 0], 200)
        ]);

        $response = $controller->getAllQuotes($request);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('quotes', $response);
        $this->assertArrayHasKey('total', $response);
        $this->assertArrayHasKey('limit', $response);
        $this->assertArrayHasKey('skip', $response);
    }
}
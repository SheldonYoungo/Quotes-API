<?php

namespace Tests\Feature;

use \PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class QuotesTest extends TestCase
{
    #[Test]
    public function get_all_quotes_test(): void
    {
        $response = $this->get('/api/quote');

        $response->assertStatus(200)
                ->assertJson(
                    fn (AssertableJson $json) =>
                    $json->has('quotes')
                        ->has('total')
                        ->has('limit')
                        ->has('skip')
                );
    }

    #[Test]
    public function get_random_quote_test(): void
    {
        $response = $this->get('/api/quote/random');

        $response->assertStatus(200)
                ->assertJson(
                    fn (AssertableJson $json) =>
                    $json->has('id')
                        ->has('quote')
                        ->has('author')
                );
    }

    public function get_quote_test(): void
    {
        $response = $this->get('/api/quote/1');

        $response->assertStatus(200)
                ->assertJson(
                    fn (AssertableJson $json) =>
                    $json->has('id')
                        ->has('quote')
                        ->has('author')
                );
    }
}

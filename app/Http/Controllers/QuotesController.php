<?php

namespace App\Http\Controllers;

use App\Services\QuoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuotesController
{
    private $quotesService;

    public function __construct(QuoteService $quotesService) {
        $this->quotesService = $quotesService;
    }

    public function getAllQuotes(Request $request) : JsonResponse {
        try {
            $quotes = $this->quotesService->getAllQuotes($request);
            return response()->json($quotes);
        } catch(\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching the quotes'], 500);
        }
    }

    public function getRandomQuote() : JsonResponse {
        try {
            $quote = $this->quotesService->getRandomQuote();
            return response()->json($quote);
        } catch(\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching the random quote'], 500);
        }
    }

    public function getQuote($id) : JsonResponse {
        try {
            $quote = $this->quotesService->getQuote($id);
            return response()->json($quote);
        } catch(\Exception $e) {
            return response()->json(['error' => 'Quote not found. Try with a different ID'], 500);
        }
    }
}
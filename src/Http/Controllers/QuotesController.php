<?php

namespace QuotesApiPackage\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use QuotesApiPackage\Services\QuoteService;

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
        
        } catch(\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch(\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching the quote'], 500);
        }
    }
}
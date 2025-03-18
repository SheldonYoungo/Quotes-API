<?php

namespace App\Http\Controllers;

use Cache;
use Illuminate\Support\Facades\Config;
use Http;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Log;

class QuotesController
{
    private $uri;

    public function __construct() {
        $this->uri = Config::get('quotes.url');
    }

    public function getAllQuotes(Request $request) : array{
        try{
            $limit = $request->query('limit', 10);;
            $skip = $request->query('skip', 0);
            
            $page = intdiv($skip, $limit); // Ejemplo: skip=30, limit=30 => page=1
    
            // Crear una clave única para la página
            $cacheKey = "quotes_page_$page";
    
            // Verificar si la página está en la caché
            if (Cache::has($cacheKey)) {
                return Cache::get($cacheKey);
            }
    
            // Obtener las citas de la API con paginación
            $response = Http::get($this->uri, [
                'skip' => $skip,
                'limit' => $limit,
            ]);
            $quotes = $response->json();
    
            // Almacenar la página en la caché
            Cache::put($cacheKey, $quotes, now()->addMinutes(30)); // Cache por 1 hora
    
            return $quotes;
        } catch(\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching the quotes'], 500);
        }
    }

    public function getRandomQuote()  {
        $response = Http::get($this->uri.'/random');
        return $response->json();
    }

    public function getQuote($id) {
        try {

            if($id <= 0 || (!is_int($id) && intval($id) != $id)) {
                return response()->json(['error' => 'Index not valid. The value must be an positive integer greater than zero.'], 400);
            }

            $quotes = Cache::get('quotes_all', []);
    
            // Verifica si la cita está en la caché mediante búsqueda binaria
            $index = $this->busquedaBinaria($quotes, $id);
    
            if ($index !== -1) {
                return $quotes[$index];
            }
    
            // Si no está en la cita en caché, se obtiene de la API
            $response = Http::get($this->uri . '/' . $id);
            $quote = $response->json();
    
            if ($quote) {
                // Agregar la cita a la caché en orden numérico
                $quotes = $this->insertQuoteInOrder($quotes, $quote);
                Cache::put('quotes_all', $quotes, now()->addHours(1)); // Actualizar la caché
            }
    
            return $quote;
        } catch(\Exception $e) {
            return response()->json(['error' => 'Quote not found. Try with a different ID'], 500);
        }
    
    }
    
    // Función que se encarga de buscar una cita en el arreglo de citas
    private function busquedaBinaria(array $arr, int $target) : int {
        $left = 0;
        $right = count($arr) - 1;

        while ($left <= $right) {
            $mid = $left + ($right - $left) / 2;

            if ($arr[$mid]['id'] == $target) {
                return $mid;
            }

            if ($arr[$mid]['id'] < $target) {
                $left = $mid + 1;
            } else {
                $right = $mid - 1;
            }
        }

        return -1;
    }

    // Función que se encarga de insertar una cita en el arreglo de citas manteniendo el orden
    private function insertQuoteInOrder(array $quotes, array $quote): array
    {
        $low = 0;
        $high = count($quotes) - 1;

        
        while ($low <= $high) {
            $mid = (int)(($low + $high) / 2);

            if ($quotes[$mid]['id'] < $quote['id']) {
                $low = $mid + 1;
            } else {
                $high = $mid - 1;
            }
        }

        array_splice($quotes, $low, 0, [$quote]);

        return $quotes;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function getPincsumData(): \Illuminate\Http\JsonResponse
    {
        try {
            $response = Http::get('https://picsum.photos/v2/list');


            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json(['message' => 'Error al obtener datos de la API de Picsum'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al procesar la solicitud', 'error' => $e->getMessage()], 500);
        }
    }
}

<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/picsum-proxy', function () {
    // Hacemos la solicitud a la API de Picsum
    $response = Http::get('https://picsum.photos/v2/list');

    // Devolvemos la respuesta como JSON
    return $response->json();
});

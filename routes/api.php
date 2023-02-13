<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LobbyController;
use App\Http\Controllers\StreamController;
use App\WebSocket\SocketHandler\UpdatePostSocketHandler;
use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::controller(LobbyController::class)->group(function(){
   Route::group(['prefix' => 'lobby'], function(){
       Route::get('index', 'index');
       Route::post('create', 'store');
       Route::post('show/{lobby}', 'show');
       Route::delete('delete/{lobby}', 'destroy');
   });
});

Route::get('stream', [StreamController::class, 'stream']);

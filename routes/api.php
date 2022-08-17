<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CmdController;
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

Route::post('v1/login', [AuthController::class, 'signin']);
//Route::post('register', [AuthController::class, 'signup']);

Route::middleware('auth:sanctum')->group(function() {
    Route::prefix('v1')->group(function() {
        Route::get('/look', [CmdController::class, 'look']);
        Route::get('/go', [CmdController::class, 'go']);
    });
});



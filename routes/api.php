<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlueprintController;
use App\Http\Controllers\Api\CmdController;
use App\Http\Controllers\Api\EventMessageController;
use App\Http\Controllers\Api\GuildController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\MapController;
use App\Http\Controllers\Api\PlayerController;
use App\Http\Controllers\Api\QuestController;
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

Route::middleware(['auth:sanctum', 'throttle:9000,1'])->group(function () {
    Route::prefix('v1')->group(function () {
        Route::get('look', [CmdController::class, 'look']);
        Route::get('go', [CmdController::class, 'go']);
        Route::get('take', [CmdController::class, 'take']);
        Route::post('interact', [CmdController::class, 'interact']);
        Route::prefix('inventories')->group(function () {
            Route::get('/', [InventoryController::class, 'show']);
            Route::get('/discard', [InventoryController::class, 'discard']);
            Route::get('/eat', [InventoryController::class, 'eat']);
            Route::post('/craft', [InventoryController::class, 'craft']);
        });
        Route::prefix('quests')->group(function () {
            Route::get('/resolve', [QuestController::class, 'resolve']);
            Route::get('/', [QuestController::class, 'index']);
        });
        Route::prefix('event-messages')->group(function () {
            Route::get('/', [EventMessageController::class, 'index']);
        });
        Route::prefix('players')->group(function () {
            Route::get('/', [PlayerController::class, 'show']);
        });
        Route::prefix('map')->group(function () {
            Route::get('/claim', [MapController::class, 'claim']);
        });
        Route::prefix('blueprints')->group(function () {
            Route::get('/', [BlueprintController::class, 'show']);
        });
        Route::prefix('guilds')->group(function () {
            Route::get('/', [GuildController::class, 'index']);
            Route::post('/apply', [GuildController::class, 'apply']);
            Route::post('/approve', [GuildController::class, 'approve']);
            Route::post('/', [GuildController::class, 'create']);
        });
    });
});

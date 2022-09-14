<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\KapalController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EksesaisController;

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

Route::post('login', [AuthController::class, 'loginUser']);

Route::middleware([
    'auth:sanctum',
])->group(function () {

    Route::get('kapal/ajax', [KapalController::class, 'index']);
    Route::post('eksesaisdata', [EksesaisController::class, 'store']);
    Route::get('eksesaisdata', [EksesaisController::class, 'index']);
    Route::get('/senaraikapal/{eksesaisId}', [KapalController::class, 'senaraikapaldalameksesais']);
    Route::get('eksesais/callsign/all', [EksesaisController::class, 'getcallsign']);
    Route::get('eksesais/{id}/rooms/users', [EksesaisController::class, 'getusersonallroomineksesais']);
    Route::get('chat/eksesais/{eksesaisId}/messages', [ChatController::class, 'messages'])->name('eksesaismessage');
    Route::post('/eksesais/{eksesaisId}/group/{roomId}/updateseenmessage', [ChatController::class, 'updateseenmessage']);
    Route::post('/chat/eksesais/{eksesaisId}/{roomId}/message', [ChatController::class, 'newMessage']);
    Route::get('kapal/callsign', [KapalController::class, 'getcallsign']);
    Route::get('callsign/eksesais', [EksesaisController::class, 'getcallsigneksesais']);
    Route::post('/saveallcallsign', [KapalController::class, 'savecallsign']);
    Route::post('/chat/eksesais/{eksesaisId}/{roomId}/{messageId}/messageId', [ChatController::class, 'updateIXMessage']);
    Route::post('/chat/eksesais/{eksesaisId}/createroom', [ChatController::class, 'newRoom']);
    Route::get('/chat/rooms/{eksesaisId}', [ChatController::class, 'rooms']);
    Route::get('eksesaisdetail/{eksesaisId}', [EksesaisController::class, 'eksesaisdetail']);

});

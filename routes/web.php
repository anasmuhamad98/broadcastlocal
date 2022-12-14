<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\EksesaisController;
use App\Http\Controllers\KapalController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', [EksesaisController::class, 'authuser']);
Route::get('login', function(){
    return redirect('/');
});
// function () {

//     $user = User::find(1);
//     Auth::login($user);
//     return redirect('/eksesais');
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function(){
        return redirect('/eksesais');
    });
    Route::get('/eksesais', [EksesaisController::class, 'index'])->name('eksesais');

    Route::get('/eksesaisdata',  [EksesaisController::class, 'geteksesais']);

    Route::get('/eksesais/{id}', [ChatController::class, 'index'])->name('eksesaischat');


    Route::get('/callsign', function () {
        return Inertia::render('Callsign');
    })->name('callsign');

    Route::get('/chat', function () {
        return Inertia::render('Chat/container');
    })->name('chat');


    Route::get('chat/eksesais/{eksesaisId}/messages', [ChatController::class, 'messages'])->name('eksesaismessage');
    Route::get('/chat/rooms/{eksesaisId}', [ChatController::class, 'rooms']);

    Route::get('/room/users/{roomId}', [ChatController::class, 'users_room']);
    Route::post('/chat/eksesais/{eksesaisId}/{roomId}/message', [ChatController::class, 'newMessage']);

    Route::post('/chat/eksesais/{eksesaisId}/{roomId}/{messageId}/messageId', [ChatController::class, 'updateIXMessage']);
    Route::post('/chat/eksesais/{eksesaisId}/createroom', [ChatController::class, 'newRoom']);
    Route::get('/senaraikapal/{eksesaisId}', [KapalController::class, 'senaraikapaldalameksesais']);
    Route::post('/saveallcallsign', [KapalController::class, 'savecallsign']);

    Route::post('/eksesais/{eksesaisId}/group/{roomId}/updateseenmessage', [ChatController::class, 'updateseenmessage']);


    Route::get('kapal/ajax', [KapalController::class, 'index']);
    Route::get('kapal/callsign', [KapalController::class, 'getcallsign']);
    Route::get('callsign/eksesais', [EksesaisController::class, 'getcallsigneksesais']);
    Route::get('eksesais/callsign/all', [EksesaisController::class, 'getcallsign']);
    Route::get('eksesais/{id}/rooms/users', [EksesaisController::class, 'getusersonallroomineksesais']);

    Route::get('eksesaisdetail/{eksesaisId}', [EksesaisController::class, 'eksesaisdetail']);
});


Route::post('/testasdasdasdafdsf', [ChatController::class, 'testets']);

// Route::get('/test', function () {
//     return view('welcome');
// });



Route::middleware('auth:sanctum')->get('/chat/room/{roomId}/messages', [ChatController::class, 'messages']);
Route::get('grouper/ajax/meaning', [ChatController::class, 'chatmeaning']);

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');


Route::post('auth/login', [AuthController::class, 'loginUser']);

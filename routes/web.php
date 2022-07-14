<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\EksesaisController;
use App\Http\Controllers\KapalController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;

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

Route::get('/', function () {

    return redirect('/eksesais');
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/chat', function () {
        return Inertia::render('Chat/container');
    })->name('chat');

    Route::get('/eksesais', function () {
        return Inertia::render('Eksesais');
    })->name('eksesais');

    // Route::get('/eksesais/{id}', function () {
    //     return Inertia::render('Chat/container', ['create_url' => 'asdasd']);
    // })->name('eksesaischat');
    Route::get('/eksesais/{id}', [ChatController::class, 'index'])->name('eksesaischat');
    Route::get('chat/eksesais/{eksesaisId}/{roomId}/messages', [ChatController::class, 'messages'])->name('eksesaismessage');
    Route::get('/chat/rooms/{eksesaisId}', [ChatController::class, 'rooms']);
    Route::post('/chat/eksesais/{eksesaisId}/{roomId}/message', [ChatController::class, 'newMessage']);

    Route::post('/chat/eksesais/{eksesaisId}/createroom', [ChatController::class, 'newRoom']);
    Route::get('/senaraikapal/{eksesaisId}', [KapalController::class, 'senaraikapaldalamrooms']);

    Route::post('/eksesais/{eksesaisId}/group/{roomId}/updateseenmessage', [ChatController::class, 'updateseenmessage']);
    Route::get('/testasdasdasdafdsf', [ChatController::class, 'testets']);
});




// Route::get('/test', function () {
//     return view('welcome');
// });



Route::middleware('auth:sanctum')->get('/chat/room/{roomId}/messages', [ChatController::class, 'messages']);
// Route::middleware('auth:sanctum')->post('/chat/room/{roomId}/message', [ChatController::class, 'newMessage']);
Route::get('grouper/ajax/meaning', [ChatController::class, 'chatmeaning']);
Route::get('kapal/ajax', [KapalController::class, 'index']);

Route::resource('/eksesaisdata', EksesaisController::class);

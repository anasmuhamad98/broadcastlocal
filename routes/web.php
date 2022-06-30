<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\EksesaisController;
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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});




Route::get('/test', function () {
    return view('welcome');
});

// Route::get('/login', function () {
//     return auth()->login(User::where('name', 'ezzat12')->first());

// });


// Route::get('/logout', function () {
//     return  auth()->logout(User::first());
//  });

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::get('/chat', function () {
        return Inertia::render('Chat/container');
    })->name('chat');

    Route::get('/eksesais', function () {
        return Inertia::render('Eksesais');
    })->name('eksesais');
});


Route::middleware('auth:sanctum')->get('/chat/rooms', [ChatController::class, 'rooms']);
Route::middleware('auth:sanctum')->get('/chat/room/{roomId}/messages', [ChatController::class, 'messages']);
Route::middleware('auth:sanctum')->post('/chat/room/{roomId}/message', [ChatController::class, 'newMessage']);
Route::get('grouper/ajax/meaning', [ChatController::class, 'chatmeaning']);

Route::resource('/eksesaisdata', EksesaisController::class);

<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SimpleController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TextToSpeechController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

// Simple direct route to test basic routing
Route::get('/hello', function() {
    return 'Hello World';
});

// Home route using direct closure instead of controller
Route::get('/', function() {
    return view('welcome');
});

// Controller route tests
Route::get('/simple', [SimpleController::class, 'index']);
Route::get('/test', [TestController::class, 'index']);

// Book routes
Route::get('/books', [BookController::class, 'create']);
Route::get('/books/index', [BookController::class, 'index']);
Route::get('/books/{book}', [BookController::class, 'show']);
Route::post('/books', [BookController::class, 'store']);
Route::get('/books/{book}/edit', [BookController::class, 'edit']);
Route::patch('/books/{book}', [BookController::class, 'update']);
Route::delete('/books/{book}', [BookController::class, 'delete']);
Route::post('/tts', [TextToSpeechController::class, 'convertToSpeech']);


// Auth
Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);

//Route::resource('books', BookController::class);

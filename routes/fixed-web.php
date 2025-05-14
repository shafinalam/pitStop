<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home page
Route::get('/', function() {
    return Inertia::render('Home');
})->name('home');

// About page
Route::get('/about', function() {
    return Inertia::render('About');
})->name('about');

// Contact page
Route::get('/contact', function() {
    return Inertia::render('Contact');
})->name('contact');

// Services page
Route::get('/services', function() {
    return Inertia::render('Services');
})->name('services');

// Mechanics listing page
Route::get('/mechanics', [MechanicController::class, 'index'])->name('mechanics');

/*
|--------------------------------------------------------------------------
| Appointment Routes - Fixed version with full controller path
|--------------------------------------------------------------------------
*/
// List all appointments
Route::get('/appointments', 
    [App\Http\Controllers\AppointmentController::class, 'index'])
    ->name('appointments.index');

// Create new appointment form
Route::get('/appointments/create', 
    [App\Http\Controllers\AppointmentController::class, 'create'])
    ->name('appointments.create');

// Store new appointment
Route::post('/appointments', 
    [App\Http\Controllers\AppointmentController::class, 'store'])
    ->name('appointments.store');

// View appointment details
Route::get('/appointments/{appointment}', 
    [App\Http\Controllers\AppointmentController::class, 'show'])
    ->name('appointments.show');

// Edit appointment form
Route::get('/appointments/{appointment}/edit', 
    [App\Http\Controllers\AppointmentController::class, 'edit'])
    ->name('appointments.edit');

// Update appointment
Route::patch('/appointments/{appointment}', 
    [App\Http\Controllers\AppointmentController::class, 'update'])
    ->name('appointments.update');

// Delete appointment
Route::delete('/appointments/{appointment}', 
    [App\Http\Controllers\AppointmentController::class, 'destroy'])
    ->name('appointments.destroy');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']); 
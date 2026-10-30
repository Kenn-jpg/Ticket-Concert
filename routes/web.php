<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', [
        'eventDate' => now('Asia/Jakarta'),
    ]);
})->name('home');

Route::post('/registrations', [RegistrationController::class, 'store'])->name('registrations.store');

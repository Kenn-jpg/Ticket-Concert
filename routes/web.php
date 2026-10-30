<?php

use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\RegistrationPaymentController;
use App\Http\Controllers\RegistrationPaymentMethodController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', [
        'eventDate' => now('Asia/Jakarta'),
    ]);
})->name('home');

Route::post('/registrations', [RegistrationController::class, 'store'])->name('registrations.store');

Route::middleware('signed')->group(function () {
    Route::get('/registrations/{registration}/payment', [RegistrationPaymentController::class, 'show'])->name('registrations.payment.show');
    Route::post('/registrations/{registration}/payment', [RegistrationPaymentController::class, 'store'])->name('registrations.payment.store');
    Route::put('/registrations/{registration}/payment-method', [RegistrationPaymentMethodController::class, 'update'])->name('registrations.payment-method.update');
});

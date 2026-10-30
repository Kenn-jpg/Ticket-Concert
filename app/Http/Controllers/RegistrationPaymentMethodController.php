<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;

class RegistrationPaymentMethodController extends Controller
{
    /**
     * Change the payment method of a registration that has not been paid yet.
     */
    public function update(Request $request, Registration $registration): RedirectResponse
    {
        $validated = $request->validate([
            'payment' => ['required', Rule::in(Registration::PAYMENT_METHODS)],
        ]);

        if (! $registration->isPaid()) {
            $registration->update(['payment_method' => $validated['payment']]);
        }

        return redirect(URL::signedRoute('registrations.payment.show', $registration));
    }
}

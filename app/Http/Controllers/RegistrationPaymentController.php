<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationEmail;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class RegistrationPaymentController extends Controller
{
    /**
     * Show the simulated payment page of a registration.
     */
    public function show(Registration $registration): View
    {
        return view('payment', [
            'registration' => $registration,
            'eventDate' => $registration->created_at->timezone('Asia/Jakarta')->locale('id'),
        ]);
    }

    /**
     * Mark the registration as paid and send the e-ticket email.
     *
     * The e-ticket is only sent the first time a registration is paid. When the
     * email cannot be sent, the payment is rolled back so the registrant can retry.
     */
    public function store(Registration $registration): RedirectResponse
    {
        DB::transaction(function () use ($registration): void {
            $wasMarkedAsPaid = Registration::query()
                ->whereKey($registration->getKey())
                ->where('status', Registration::STATUS_PENDING)
                ->update([
                    'status' => Registration::STATUS_PAID,
                    'paid_at' => now(),
                ]) === 1;

            if ($wasMarkedAsPaid) {
                Mail::send(new RegistrationEmail($registration->refresh()));
            }
        });

        return redirect(URL::signedRoute('registrations.payment.show', $registration));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\URL;

class RegistrationController extends Controller
{
    /**
     * Store a new ticket registration and continue to its payment page.
     */
    public function store(StoreRegistrationRequest $request): RedirectResponse
    {
        $ticketType = $request->validated('ticket');
        $quantity = (int) $request->validated('quantity');

        $registration = Registration::create([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'phone' => $request->validated('phone'),
            'ticket_type' => $ticketType,
            'quantity' => $quantity,
            'payment_method' => $request->validated('payment'),
            'total_price' => Registration::TICKET_PRICES[$ticketType] * $quantity,
        ]);

        return redirect(URL::signedRoute('registrations.payment.show', $registration));
    }
}

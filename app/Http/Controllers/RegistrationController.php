<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Mail\RegistrationEmail;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    /**
     * Store a new ticket registration from the landing page.
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

        Mail::send(new RegistrationEmail($registration->email, $registration->name));

        return redirect()
            ->route('home')
            ->with('success', "Terima kasih, {$registration->name}. Data pendaftaran tersimpan. Detail pembayaran akan dikirim ke email kamu.");
    }
}

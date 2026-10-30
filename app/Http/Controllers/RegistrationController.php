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
            ->with('success', sprintf(
                'Pendaftaran berhasil, %s! Pesanan %d tiket (total %s) sudah kami catat, dan email konfirmasi sudah dikirim ke %s. Belum masuk? Coba cek folder Spam.',
                $registration->name,
                $registration->quantity,
                'Rp'.number_format($registration->total_price, 0, ',', '.'),
                $registration->email,
            ));
    }
}

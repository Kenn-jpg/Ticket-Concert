<?php

namespace App\Models;

use Database\Factories\RegistrationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'email', 'phone', 'ticket_type', 'quantity', 'payment_method', 'total_price'])]
class Registration extends Model
{
    /** @use HasFactory<RegistrationFactory> */
    use HasFactory;

    /**
     * Ticket prices in Rupiah, keyed by ticket type.
     *
     * @var array<string, int>
     */
    public const TICKET_PRICES = [
        'regular' => 350000,
        'premium' => 750000,
        'vip' => 1500000,
    ];

    /**
     * Available payment methods.
     *
     * @var list<string>
     */
    public const PAYMENT_METHODS = ['qris', 'bank', 'ewallet'];

    /**
     * Maximum number of tickets per registration.
     */
    public const MAX_QUANTITY = 6;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'total_price' => 'integer',
        ];
    }
}

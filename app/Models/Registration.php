<?php

namespace App\Models;

use Database\Factories\RegistrationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'email', 'phone', 'ticket_type', 'quantity', 'payment_method', 'total_price'])]
class Registration extends Model
{
    /** @use HasFactory<RegistrationFactory> */
    use HasFactory;

    /**
     * Status of a registration that has not been paid yet.
     */
    public const STATUS_PENDING = 'pending';

    /**
     * Status of a registration that has been paid.
     */
    public const STATUS_PAID = 'paid';

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
     * Display labels for each ticket type.
     *
     * @var array<string, string>
     */
    public const TICKET_LABELS = [
        'regular' => 'Regular',
        'premium' => 'Premium',
        'vip' => 'VIP',
    ];

    /**
     * Available payment methods.
     *
     * @var list<string>
     */
    public const PAYMENT_METHODS = ['qris', 'bank', 'ewallet'];

    /**
     * Display labels for each payment method.
     *
     * @var array<string, string>
     */
    public const PAYMENT_LABELS = [
        'qris' => 'QRIS',
        'bank' => 'Transfer bank',
        'ewallet' => 'E-wallet',
    ];

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
            'paid_at' => 'datetime',
        ];
    }

    /**
     * Determine whether the registration has been paid.
     */
    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    /**
     * Get the registration code shown to the registrant, e.g. ME26-00001.
     */
    protected function code(): Attribute
    {
        return Attribute::get(fn (): string => 'ME26-'.str_pad((string) $this->id, 5, '0', STR_PAD_LEFT));
    }

    /**
     * Get the simulated payment code, e.g. 8808 0000 0000 0001.
     */
    protected function paymentCode(): Attribute
    {
        return Attribute::get(fn (): string => implode(' ', str_split('8808'.str_pad((string) $this->id, 12, '0', STR_PAD_LEFT), 4)));
    }

    /**
     * Get the display label of the ticket type.
     */
    protected function ticketLabel(): Attribute
    {
        return Attribute::get(fn (): string => self::TICKET_LABELS[$this->ticket_type] ?? $this->ticket_type);
    }

    /**
     * Get the display label of the payment method.
     */
    protected function paymentLabel(): Attribute
    {
        return Attribute::get(fn (): string => self::PAYMENT_LABELS[$this->payment_method] ?? $this->payment_method);
    }

    /**
     * Get the total price formatted as Rupiah, e.g. Rp350.000.
     */
    protected function formattedTotalPrice(): Attribute
    {
        return Attribute::get(fn (): string => 'Rp'.number_format($this->total_price, 0, ',', '.'));
    }
}

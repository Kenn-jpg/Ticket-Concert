<?php

namespace Tests\Feature;

use App\Mail\RegistrationEmail;
use App\Models\Registration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
    }

    /**
     * Get a valid registration payload from the landing page form.
     *
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'ticket' => 'premium',
            'quantity' => 2,
            'payment' => 'qris',
            'agreement' => '1',
        ], $overrides);
    }

    public function test_registration_is_stored_as_pending_and_redirects_to_payment_page(): void
    {
        $response = $this->post(route('registrations.store'), $this->validPayload([
            'total_price' => 1,
        ]));

        $registration = Registration::sole();

        $response->assertRedirect(URL::signedRoute('registrations.payment.show', $registration));
        $this->assertDatabaseHas('registrations', [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'ticket_type' => 'premium',
            'quantity' => 2,
            'payment_method' => 'qris',
            'total_price' => 1500000,
            'status' => Registration::STATUS_PENDING,
            'paid_at' => null,
        ]);
        Mail::assertNothingSent();
    }

    public function test_registration_requires_valid_input(): void
    {
        $response = $this->post(route('registrations.store'), $this->validPayload([
            'email' => 'bukan-email',
            'phone' => '12345',
            'ticket' => 'backstage',
            'quantity' => Registration::MAX_QUANTITY + 1,
            'payment' => 'cash',
            'agreement' => null,
        ]));

        $response->assertSessionHasErrors(['email', 'phone', 'ticket', 'quantity', 'payment', 'agreement']);
        $this->assertDatabaseCount('registrations', 0);
        Mail::assertNothingSent();
    }

    public function test_landing_page_shows_today_date_in_jakarta_time(): void
    {
        $this->travelTo(now('Asia/Jakarta')->setDate(2027, 1, 1)->setTime(0, 30));

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Jumat, 1 Januari 2027');
    }

    public function test_payment_page_shows_payment_instructions_for_pending_registration(): void
    {
        $registration = Registration::factory()->create([
            'payment_method' => 'bank',
            'total_price' => 750000,
        ]);

        $this->get(URL::signedRoute('registrations.payment.show', $registration))
            ->assertOk()
            ->assertSee('Menunggu pembayaran')
            ->assertSee('Nomor Virtual Account')
            ->assertSee($registration->payment_code)
            ->assertSee('Rp750.000')
            ->assertSee('Saya sudah bayar');
    }

    public function test_payment_page_requires_a_valid_signature(): void
    {
        $registration = Registration::factory()->create();

        $this->get(route('registrations.payment.show', $registration))->assertForbidden();
        $this->post(route('registrations.payment.store', $registration))->assertForbidden();

        $this->assertFalse($registration->refresh()->isPaid());
    }

    public function test_paying_marks_registration_as_paid_and_sends_e_ticket(): void
    {
        $registration = Registration::factory()->create(['email' => 'budi@example.com']);

        $this->post(URL::signedRoute('registrations.payment.store', $registration))
            ->assertRedirect(URL::signedRoute('registrations.payment.show', $registration));

        $registration->refresh();

        $this->assertTrue($registration->isPaid());
        $this->assertNotNull($registration->paid_at);
        Mail::assertSent(RegistrationEmail::class, function (RegistrationEmail $mail) use ($registration): bool {
            return $mail->hasTo('budi@example.com')
                && $mail->registration->is($registration);
        });
    }

    public function test_paying_twice_only_sends_one_e_ticket(): void
    {
        $registration = Registration::factory()->create();
        $paymentUrl = URL::signedRoute('registrations.payment.store', $registration);

        $this->post($paymentUrl);
        $this->post($paymentUrl);

        Mail::assertSentCount(1);
    }

    public function test_payment_page_shows_success_state_after_paying(): void
    {
        $registration = Registration::factory()->create(['name' => 'Budi Santoso']);

        $this->followingRedirects()
            ->post(URL::signedRoute('registrations.payment.store', $registration))
            ->assertOk()
            ->assertSee('Pembayaran diterima')
            ->assertSee('Lunas')
            ->assertSee($registration->code)
            ->assertDontSee('Saya sudah bayar');
    }

    public function test_e_ticket_email_shows_order_details(): void
    {
        $registration = Registration::factory()->paid()->create([
            'name' => 'Budi Santoso',
            'ticket_type' => 'vip',
            'quantity' => 2,
            'payment_method' => 'bank',
            'total_price' => 3000000,
        ]);

        $mail = new RegistrationEmail($registration);

        $mail->assertHasSubject("E-ticket Midnight Echoes ({$registration->code})");
        $mail->assertSeeInHtml('Budi Santoso');
        $mail->assertSeeInHtml($registration->code);
        $mail->assertSeeInHtml('VIP');
        $mail->assertSeeInHtml('2 tiket');
        $mail->assertSeeInHtml('Transfer bank');
        $mail->assertSeeInHtml('Rp3.000.000');
        $mail->assertSeeInHtml('Lunas');
    }
}

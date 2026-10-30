<?php

namespace Tests\Feature;

use App\Mail\RegistrationEmail;
use App\Models\Registration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
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

    public function test_registration_is_stored_with_server_calculated_total(): void
    {
        $response = $this->post(route('registrations.store'), $this->validPayload([
            'total_price' => 1,
        ]));

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('success');

        $this->assertDatabaseCount('registrations', 1);
        $this->assertDatabaseHas('registrations', [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'ticket_type' => 'premium',
            'quantity' => 2,
            'payment_method' => 'qris',
            'total_price' => 1500000,
        ]);
    }

    public function test_registration_email_is_sent_to_registrant(): void
    {
        $this->post(route('registrations.store'), $this->validPayload());

        $registration = Registration::sole();

        Mail::assertSent(RegistrationEmail::class, function (RegistrationEmail $mail) use ($registration): bool {
            return $mail->hasTo('budi@example.com')
                && $mail->registration->is($registration);
        });
    }

    public function test_registration_email_shows_order_details(): void
    {
        $registration = Registration::factory()->create([
            'name' => 'Budi Santoso',
            'ticket_type' => 'vip',
            'quantity' => 2,
            'payment_method' => 'bank',
            'total_price' => 3000000,
        ]);

        $mail = new RegistrationEmail($registration);

        $mail->assertHasSubject("Pendaftaran Midnight Echoes berhasil ({$registration->code})");
        $mail->assertSeeInHtml('Budi Santoso');
        $mail->assertSeeInHtml($registration->code);
        $mail->assertSeeInHtml('VIP');
        $mail->assertSeeInHtml('2 tiket');
        $mail->assertSeeInHtml('Transfer bank');
        $mail->assertSeeInHtml('Rp3.000.000');
    }

    public function test_success_message_is_shown_on_landing_page(): void
    {
        $this->followingRedirects()
            ->post(route('registrations.store'), $this->validPayload())
            ->assertOk()
            ->assertSee('Pendaftaran berhasil, Budi Santoso!')
            ->assertSee('Pesanan 2 tiket (total Rp1.500.000)')
            ->assertSee('budi@example.com');
    }

    public function test_landing_page_shows_today_date_in_jakarta_time(): void
    {
        $this->travelTo(now('Asia/Jakarta')->setDate(2027, 1, 1)->setTime(0, 30));

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Jumat, 1 Januari 2027');
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
}

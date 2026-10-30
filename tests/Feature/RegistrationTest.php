<?php

namespace Tests\Feature;

use App\Models\Registration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_success_message_is_shown_on_landing_page(): void
    {
        $this->followingRedirects()
            ->post(route('registrations.store'), $this->validPayload())
            ->assertOk()
            ->assertSee('Terima kasih, Budi Santoso.');
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
    }
}

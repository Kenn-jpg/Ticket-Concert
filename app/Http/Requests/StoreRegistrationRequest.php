<?php

namespace App\Http\Requests;

use App\Models\Registration;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^(\+62|62|0)8[0-9]{7,12}$/'],
            'ticket' => ['required', Rule::in(array_keys(Registration::TICKET_PRICES))],
            'quantity' => ['required', 'integer', 'min:1', 'max:'.Registration::MAX_QUANTITY],
            'payment' => ['required', Rule::in(Registration::PAYMENT_METHODS)],
            'agreement' => ['accepted'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'phone.regex' => 'Nomor WhatsApp tidak valid. Gunakan format 08xxxxxxxxxx.',
            'agreement.accepted' => 'Kamu harus menyetujui syarat pembelian.',
        ];
    }
}

<?php

namespace App\Http\Requests\Pharmacy;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'medication_name' => ['required', 'string'],
            'dosage' => ['required', 'string'],
            'quantity' => ['required', 'numeric'],
            'manufacturer' => ['required', 'string'],
            'expiration_date' => ['required', 'date']
        ];
    }
}

<?php

namespace App\Http\Requests\Billing;

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
            'patient_id' => ['required', 'numeric'],
            'service_date'  => ['required', 'date'],
            'service_type'  => ['required', 'string'],
            'cost'  => ['required', 'numeric'],
            'insurance_information'  => ['required', 'string'],
            'payment_status' => ['required', 'string'],
        ];
    }
}

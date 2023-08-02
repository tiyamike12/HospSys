<?php

namespace App\Http\Requests\Billing;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'patient_id' => 'required|exists:patients,id',
            'billing_date' => 'required|date',
            'amount' => 'required|numeric',
            'payment_status' => 'required|in:pending,paid,rejected',
            'insurance_provider_id' => 'nullable',
            'medical_record_id' => 'required|numeric'
        ];
    }
}

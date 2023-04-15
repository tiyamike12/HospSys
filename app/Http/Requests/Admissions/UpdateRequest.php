<?php

namespace App\Http\Requests\Admissions;

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
            'user_id' => ['required', 'numeric'],
            'ward_id' => ['required', 'numeric'],
            'bed_id' => ['required', 'numeric'],
            'admission_date' => ['required', 'date'],
            'discharge_date' => ['date'],
            'admission_reason' => ['required', 'string'],
            'discharge_reason' => ['string'],
            'status' => ['required', 'string'],
        ];
    }
}

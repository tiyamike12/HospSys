<?php

namespace App\Http\Requests\Beds;

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
            'ward_id' => ['required', 'numeric'],
            'patient_id' => ['numeric'],
            'bed_type' => ['required', 'string'],
            'bed_status' => ['required', 'string'],
            'admission_date' => ['required', 'date'],
            'discharge_date' => [ 'date'],
        ];
    }
}

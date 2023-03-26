<?php

namespace App\Http\Requests\MedicalRecords;

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
            'visit_date' => ['required', 'string'],
            'diagnoses' => ['required', 'string', 'max:255'],
            'lab_result_id' => ['required', 'numeric'],
            'test_results' => ['required', 'string'],
            'treatment_plan' => ['required', 'string'],
        ];
    }
}

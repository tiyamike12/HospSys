<?php

namespace App\Http\Requests\LabResults;

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
            'user_id' => ['required', 'numeric'],
            'patient_id' => ['required', 'numeric'],
            'test_date' => ['required', 'date'],
            'test_name' => ['required', 'string'],
            'test_result' => ['required', 'string']
        ];
    }
}

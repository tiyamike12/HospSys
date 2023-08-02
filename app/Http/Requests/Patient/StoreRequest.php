<?php

namespace App\Http\Requests\Patient;

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
            'firstname' => ['required', 'string'],
            'surname' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'date_of_birth' => ['required', 'date'],
            'phone' => ['required', 'string'],
            'email' => ['required', 'email'],
            'physical_address' => ['required', 'string'],
            'provider_id'=> ['nullable', 'numeric'],
            'provider_number'=> ['nullable', 'string']
        ];


    }
}

<?php

namespace App\Http\Requests\LabTest;

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
            'test_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'lab_charges' => 'required|numeric|min:0',
        ];
    }
}

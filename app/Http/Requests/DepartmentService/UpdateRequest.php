<?php

namespace App\Http\Requests\DepartmentService;

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
            'service_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'department_id' => 'numeric|required',
        ];
    }
}

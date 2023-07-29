<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'username' => 'string',
//            'password' => 'string',
            'firstname' => 'string',
            'lastname' => 'string',
//            'date_of_birth' => 'date',
//            'gender' => 'string',
//            'email' => 'exists:people,email',
//            'phone' => 'exists:people,phone,',
//            'physical_address' => 'string',
//            'role_id' => 'exists:roles,id',
        ];
    }
}

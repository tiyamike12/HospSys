<?php

namespace App\Http\Requests\Appointments;

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
            'patient_id' => 'required|integer|exists:patients,id',
            'user_id' => 'required|integer|exists:users,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|string',
            'purpose' => 'required|string',
            'status' => 'nullable|string|in:scheduled,in progress,completed,canceled',
        ];
    }
}

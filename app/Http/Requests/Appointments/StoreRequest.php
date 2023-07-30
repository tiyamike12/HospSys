<?php

namespace App\Http\Requests\Appointments;

use App\Rules\OverlappingAppointmentsRule;
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
            'patient_id' => 'required|integer|exists:patients,id',
            'user_id' => 'required|integer|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => [
                'required',
                'date_format:H:i',
                new OverlappingAppointmentsRule(),
            ],
            'purpose' => 'required|string',
            'status' => 'nullable|string|in:scheduled,in progress,completed,canceled',
        ];
    }
}

<?php

namespace App\Rules;

use App\Models\Appointment;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OverlappingAppointmentsRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate($attribute, $value, Closure $fail): void
    {
        // Get the data from the input array
        $patientId = request('patient_id');
        $appointmentDate = request('appointment_date');
        $appointmentTime = request('appointment_time');

        // Check if there are any overlapping appointments for the patient
        $overlappingAppointment = Appointment::where('patient_id', $patientId)
            ->where('appointment_date', $appointmentDate)
            ->where('appointment_time', $appointmentTime)
            ->exists();


        // If there is an overlapping appointment, return a validation failure message
        if ($overlappingAppointment) {
            $fail("The patient already has an appointment at the selected date and time.");
        }
    }
}

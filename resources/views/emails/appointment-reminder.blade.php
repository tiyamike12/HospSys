@component('mail::message')
    # Appointment Reminder

    Hello {{ $patientName }},

    This is a friendly reminder of your upcoming appointment with Dr. {{ $doctorName }}.

    **Date:** {{ $appointmentDate }}
    **Time:** {{ $appointmentTime }}

    Please make sure to arrive on time for your appointment.

    Thank you and see you soon!

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent

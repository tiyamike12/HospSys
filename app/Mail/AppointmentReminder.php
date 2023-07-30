<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $patientName;
    public $doctorName;
    public $appointmentDate;
    public $appointmentTime;

    /**
     * Create a new message instance.
     */
    public function __construct($patientName, $doctorName, $appointmentDate, $appointmentTime)
    {
        $this->patientName = $patientName;
        $this->doctorName = $doctorName;
        $this->appointmentDate = $appointmentDate;
        $this->appointmentTime = $appointmentTime;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Appointment Reminder',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.appointment-reminder',
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.appointment-reminder')
            ->with([
                'patientName' => $this->patientName,
                'doctorName' => $this->doctorName,
                'appointmentDate' => $this->appointmentDate,
                'appointmentTime' => $this->appointmentTime,

            ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

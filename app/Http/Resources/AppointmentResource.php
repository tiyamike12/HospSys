<?php

namespace App\Http\Resources;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'appointment_date' => $this->appointment_date,
            'appointment_time' => $this->appointment_time,
            'purpose' => $this->purpose,
            'patient' => $this->patient,
            'status' => $this->status,
            'person' => new PersonResource(Person::where('user_id', $this->user_id)->first()), // Fetch Person data based on user_id
        ];
    }
}

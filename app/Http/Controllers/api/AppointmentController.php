<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointments\StoreRequest;
use App\Http\Requests\Appointments\UpdateRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $listData = Appointment::with('doctor.person', 'patient')->get();

        return AppointmentResource::collection($listData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): AppointmentResource
    {
        $appointment = Appointment::create([
            'patient_id' => $request->input('patient_id'),
            'user_id' => $request->input('user_id'),
            'appointment_date' => $request->input('appointment_date'),
            'appointment_time' => $request->input('appointment_time'),
            'purpose' => $request->input('purpose'),
        ]);

        return new AppointmentResource($appointment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment): AppointmentResource
    {
        return new AppointmentResource($appointment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $appointmentId): AppointmentResource
    {
        $appointment = Appointment::findOrFail($appointmentId);

        $appointment->update([
            'patient_id' => $request->input('patient_id'),
            'user_id' => $request->input('user_id'),
            'appointment_date' => $request->input('appointment_date'),
            'appointment_time' => $request->input('appointment_time'),
            'purpose' => $request->input('purpose'),
        ]);

        return new AppointmentResource($appointment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment): JsonResponse
    {
        $appointment->delete();
        return response()->json(null, 204);
    }
}

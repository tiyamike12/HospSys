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
        return AppointmentResource::collection(Appointment::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): AppointmentResource
    {
        $appointment = Appointment::create($request->validated());
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
    public function update(UpdateRequest $request, Appointment $appointment): AppointmentResource
    {
        $appointment->fill($request->validated());
        $appointment->update();

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

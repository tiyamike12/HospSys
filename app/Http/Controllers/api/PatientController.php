<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\StoreRequest;
use App\Http\Requests\Patient\UpdateRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return PatientResource::collection(Patient::all());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): PatientResource
    {
        $patient = Patient::create([
            'firstname' => $request->firstname,
            'surname' => $request->surname,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'phone' => $request->phone,
            'email' => $request->email,
            'physical_address' => $request->physical_address
        ]);

        return new PatientResource($patient);
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient): PatientResource
    {
        return new PatientResource($patient);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Patient $patient): PatientResource
    {
        $patient->firstname = $request->firstname;
        $patient->surname = $request->surname;
        $patient->gender = $request->gender;
        $patient->date_of_birth = $request->date_of_birth;
        $patient->phone = $request->phone;
        $patient->email = $request->email;
        $patient->physical_address = $request->physical_address;
        $patient->save();
        return new PatientResource($patient);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient): JsonResponse
    {
        $patient->delete();
        return response()->json(null, 204);
    }
}

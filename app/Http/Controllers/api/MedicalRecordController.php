<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicalRecords\StoreRequest;
use App\Http\Requests\MedicalRecords\UpdateRequest;
use App\Http\Resources\MedicalRecordResource;
use App\Models\MedicalRecord;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return MedicalRecordResource::collection(MedicalRecord::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): MedicalRecordResource
    {
        $medicalRecord = MedicalRecord::create([
            'patient_id' => $request->patient_id,
            'user_id' => $request->patient_id,
            'visit_date' => $request->patient_id,
            'diagnosis' => $request->patient_id,
            'discharge_date' => $request->patient_id,
            'lab_result_id' => $request->patient_id,
        ]);

        return new MedicalRecordResource($medicalRecord);
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicalRecord $medicalRecord): MedicalRecordResource
    {
        return new MedicalRecordResource($medicalRecord);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, MedicalRecord $medicalRecord): MedicalRecordResource
    {
        $medicalRecord->patient_id = $request->patient_id;
        $medicalRecord->user_id = $request->user_id;
        $medicalRecord->visit_date = $request->visit_date;
        $medicalRecord->diagnosis = $request->diagnosis;
        $medicalRecord->discharge_date = $request->discharge_date;
        $medicalRecord->lab_result_id = $request->lab_result_id;
        $medicalRecord->save();

        return new MedicalRecordResource($medicalRecord);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicalRecord $medicalRecord): JsonResponse
    {
        $medicalRecord->delete();
        return response()->json(null, 204);
    }
}

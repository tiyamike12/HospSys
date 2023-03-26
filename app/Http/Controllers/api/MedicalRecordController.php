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
        $medicalRecord = MedicalRecord::create($request->validated());
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
        $medicalRecord->fill($request->validated());
        $medicalRecord->update();

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

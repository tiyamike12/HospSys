<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LabResults\StoreRequest;
use App\Http\Requests\LabResults\UpdateRequest;
use App\Http\Resources\LabResultResource;
use App\Models\LabResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LabResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return LabResultResource::collection(LabResult::all());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): LabResultResource
    {
        $labResult = LabResult::create([
            'user_id' => $request->user_id,
            'patient_id' => $request->patient_id,
            'test_date' => $request->test_date,
            'test_name' => $request->test_name,
            'test_result' => $request->test_result
        ]);

        return new LabResultResource($labResult);
    }

    /**
     * Display the specified resource.
     */
    public function show(LabResult $labResult): LabResultResource
    {
        return new LabResultResource($labResult);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, LabResult $labResult): LabResultResource
    {
        $labResult->user_id = $request->user_id;
        $labResult->patient_id = $request->patient_id;
        $labResult->test_date = $request->test_date;
        $labResult->test_name = $request->test_name;
        $labResult->test_result = $request->test_result;
        $labResult->save();
        return new LabResultResource($labResult);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LabResult $labResult): JsonResponse
    {
        $labResult->delete();
        return response()->json(null, 204);
    }
}

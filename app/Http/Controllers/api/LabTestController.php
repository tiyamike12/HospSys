<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LabTest\StoreRequest;
use App\Http\Requests\LabTest\UpdateRequest;
use App\Http\Resources\LabResultResource;
use App\Models\LabTest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LabTestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return LabResultResource::collection(LabTest::all());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): LabResultResource
    {
        $labResult = LabTest::create($request->validated());

        return new LabResultResource($labResult);
    }

    /**
     * Display the specified resource.
     */
    public function show(LabTest $labTest): LabResultResource
    {
        return new LabResultResource($labTest);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, LabTest $labTest): LabResultResource
    {

        $labTest->update($request->validated());

        return new LabResultResource($labTest);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LabTest $labTest): JsonResponse
    {
        $labTest->delete();
        return response()->json(null, 204);
    }
}

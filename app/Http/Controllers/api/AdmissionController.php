<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admissions\StoreRequest;
use App\Http\Requests\Admissions\UpdateRequest;
use App\Http\Resources\AdmissionResource;
use App\Models\Admission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return AdmissionResource::collection(Admission::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): AdmissionResource
    {
        $admission = Admission::create($request->validated());
        return new AdmissionResource($admission);
    }

    /**
     * Display the specified resource.
     */
    public function show(Admission $admission): AdmissionResource
    {
        return new AdmissionResource($admission);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Admission $admission): AdmissionResource
    {
        $admission->fill($request->validated());
        $admission->update();

        return new AdmissionResource($admission);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admission $admission): JsonResponse
    {
        $admission->delete();
        return response()->json(null, 204);
    }
}

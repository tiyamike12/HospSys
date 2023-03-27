<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pharmacy\StoreRequest;
use App\Http\Requests\Pharmacy\UpdateRequest;
use App\Http\Resources\PharmacyResource;
use App\Models\Pharmacy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return PharmacyResource::collection(Pharmacy::all());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): PharmacyResource
    {
        $pharmacy = Pharmacy::create($request->validated());
        return new PharmacyResource($pharmacy);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pharmacy $pharmacy): PharmacyResource
    {
        return new PharmacyResource($pharmacy);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Pharmacy $pharmacy): PharmacyResource
    {
        $pharmacy->fill($request->validated());
        $pharmacy->update();
        return new PharmacyResource($pharmacy);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pharmacy $pharmacy): JsonResponse
    {
        $pharmacy->delete();
        return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wards\StoreRequest;
use App\Http\Requests\Wards\UpdateRequest;
use App\Http\Resources\WardResource;
use App\Models\Ward;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class WardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return WardResource::collection(Ward::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): WardResource
    {
        $ward = Ward::create($request->validated());
        return new WardResource($ward);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ward $ward): WardResource
    {
        return new WardResource($ward);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Ward $ward): WardResource
    {
        $ward->fill($request->validated());
        $ward->update();
        return new WardResource($ward);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ward $ward): JsonResponse
    {
        $ward->delete();
        return response()->json(null, 204);
    }
}

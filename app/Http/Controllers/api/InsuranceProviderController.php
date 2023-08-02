<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InsuranceProvider\StoreRequest;
use App\Http\Requests\InsuranceProvider\UpdateRequest;
use App\Http\Resources\InsuranceProviderResource;
use App\Models\InsuranceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class InsuranceProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return InsuranceProviderResource::collection(InsuranceProvider::all());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $insuranceProvider = InsuranceProvider::create($request->validated());

        return new InsuranceProviderResource($insuranceProvider);
    }

    /**
     * Display the specified resource.
     */
    public function show(InsuranceProvider $insuranceProvider)
    {
        return new InsuranceProviderResource($insuranceProvider);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, InsuranceProvider $insuranceProvider)
    {
        $insuranceProvider->update($request->validated());

        return new InsuranceProviderResource($insuranceProvider);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InsuranceProvider $insuranceProvider)
    {
        $insuranceProvider->delete();
        return response()->json(null, 204);
    }
}

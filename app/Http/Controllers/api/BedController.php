<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Beds\StoreRequest;
use App\Http\Requests\Beds\UpdateRequest;
use App\Http\Resources\BedResource;
use App\Models\Bed;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return BedResource::collection(Bed::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): BedResource
    {
        $bed = Bed::create($request->validated());
        return new BedResource($bed);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bed $bed): BedResource
    {
        return new BedResource($bed);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Bed $bed): BedResource
    {
        $bed->fill($request->validated());
        $bed->update();
        return new BedResource($bed);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bed $bed): JsonResponse
    {
        $bed->delete();
        return response()->json(null, 204);
    }
}

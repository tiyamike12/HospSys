<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\StoreRequest;
use App\Http\Requests\Inventory\UpdateRequest;
use App\Http\Resources\InventoryResource;
use App\Models\Inventory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return InventoryResource::collection(Inventory::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): InventoryResource
    {
        $inventory = Inventory::create($request->validated());
        return new InventoryResource($inventory);
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory): InventoryResource
    {
        return new InventoryResource($inventory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Inventory $inventory): InventoryResource
    {
        $inventory->fill($request->validated());
        $inventory->update();
        return new InventoryResource($inventory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory): JsonResponse
    {
        $inventory->delete();
        return response()->json(null, 204);
    }
}

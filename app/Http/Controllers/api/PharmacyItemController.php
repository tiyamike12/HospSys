<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pharmacy\StoreRequest;
use App\Http\Requests\Pharmacy\UpdateRequest;
use App\Http\Resources\PharmacyResource;
use App\Models\PharmacyItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PharmacyItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return PharmacyResource::collection(PharmacyItem::all());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $pharmacyItem = PharmacyItem::create($request->only([
            'item_name', 'description', 'quantity_available', 'unit_price', 'initial_quantity', 'threshold_quantity'
        ]));
        // Set the current quantity to the initial quantity
        $pharmacyItem->current_quantity = $pharmacyItem->initial_quantity;
        $pharmacyItem->save();

        return response()->json($pharmacyItem, 201);    }

    /**
     * Display the specified resource.
     */
    public function show(PharmacyItem $pharmacyItem): PharmacyResource
    {
        return new PharmacyResource($pharmacyItem);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, PharmacyItem $pharmacyItem): JsonResponse
    {
        $pharmacyItem->update($request->only([
            'item_name', 'description', 'unit_price', 'initial_quantity', 'current_quantity', 'threshold_quantity'
        ]));
        return response()->json(['message' => 'Pharmacy item updated successfully'], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PharmacyItem $pharmacyItem): JsonResponse
    {
        $pharmacyItem->delete();
        return response()->json(null, 204);
    }
}

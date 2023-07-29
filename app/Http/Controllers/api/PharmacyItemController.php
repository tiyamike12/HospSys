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
    public function store(StoreRequest $request): PharmacyResource
    {
        $pharmacy = PharmacyItem::create($request->validated());
        return new PharmacyResource($pharmacy);
    }

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
    public function update(UpdateRequest $request, PharmacyItem $pharmacyItem): PharmacyResource
    {
        $pharmacyItem->fill($request->validated());
        $pharmacyItem->update();
        return new PharmacyResource($pharmacyItem);
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

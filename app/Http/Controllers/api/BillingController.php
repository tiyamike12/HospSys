<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Billing\StoreRequest;
use App\Http\Requests\Billing\UpdateRequest;
use App\Http\Resources\BillingResource;
use App\Models\Billing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $billings = Billing::with('patient' )->get();

        return BillingResource::collection($billings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): BillingResource
    {
        $billing = Billing::create($request->validated());
        return new BillingResource($billing);
    }

    /**
     * Display the specified resource.
     */
    public function show(Billing $billing): BillingResource
    {
        return new BillingResource($billing);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Billing $billing): BillingResource
    {
        $billing->fill($request->validated());
        $billing->update();

        return new BillingResource($billing);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Billing $billing): JsonResponse
    {
        $billing->delete();
        return response()->json(null, 204);
    }
}

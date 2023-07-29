<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OperationTheatre\StoreRequest;
use App\Http\Requests\OperationTheatre\UpdateRequest;
use App\Http\Resources\OperationTheatreResource;
use App\Models\OperationTheatre;
use Illuminate\Http\Request;

class OperationTheatreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return OperationTheatreResource::collection(OperationTheatre::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $operationTheatre = OperationTheatre::create($request->validated());

        return new OperationTheatreResource($operationTheatre);
    }

    /**
     * Display the specified resource.
     */
    public function show(OperationTheatre $operationTheatre)
    {
        return new OperationTheatreResource($operationTheatre);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, OperationTheatre $operationTheatre)
    {
        $operationTheatre->update($request->validated());

        return new OperationTheatreResource($operationTheatre);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OperationTheatre $operationTheatre)
    {
        $operationTheatre->delete();
        return response()->json(null, 204);
    }
}

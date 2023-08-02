<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentService\StoreRequest;
use App\Http\Requests\DepartmentService\UpdateRequest;
use App\Http\Resources\DepartmentServiceResource;
use App\Models\DepartmentService;
use Illuminate\Http\Request;

class DepartmentServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $departmentServices = DepartmentService::with('department')->get();

        return DepartmentServiceResource::collection($departmentServices);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $departmentService = DepartmentService::create($request->validated());

        return new DepartmentServiceResource($departmentService);
    }

    /**
     * Display the specified resource.
     */
    public function show(DepartmentService $departmentService)
    {
        return new DepartmentServiceResource($departmentService);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, DepartmentService $departmentService)
    {
        $departmentService->update($request->validated());

        return new DepartmentServiceResource($departmentService);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DepartmentService $departmentService)
    {
        $departmentService->delete();
        return response()->json(null, 204);
    }
}

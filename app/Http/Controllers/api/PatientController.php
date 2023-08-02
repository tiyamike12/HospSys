<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\SearchRequest;
use App\Http\Requests\Patient\StoreRequest;
use App\Http\Requests\Patient\UpdateRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        // Define the number of patients to show per page
        $perPage = 20;

        // Retrieve paginated patients
        $patients = Patient::paginate($perPage);

        // Convert the paginated patients to a LengthAwarePaginator instance
        $paginator = new LengthAwarePaginator(
            $patients->items(), // The items to be paginated
            $patients->total(), // Total number of items
            $patients->perPage(), // Items per page
            $patients->currentPage(), // Current page
            ['path' => request()->url()] // Additional paginator options if needed
        );

        return PatientResource::collection($paginator);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $patient = Patient::create($request->validated());
        return response()->json([
            'message' => 'Patient created successfully',
            'data' => $patient,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient): PatientResource
    {
        return new PatientResource($patient);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Patient $patient): PatientResource
    {
        $patient->fill($request->validated());
        $patient->update();
        return new PatientResource($patient);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient): JsonResponse
    {
        $patient->delete();
        return response()->json(null, 204);
    }

    public function search(SearchRequest $request)
    {
        $searchQuery = $request->input('q');

        $patients = Patient::where('firstname', 'LIKE', "%$searchQuery%")
            ->orWhere('surname', 'LIKE', "%$searchQuery%")
            ->orWhere('email', 'LIKE', "%$searchQuery%")
            ->orWhere('phone', 'LIKE', "%$searchQuery%")
            ->get();

        return response()->json($patients);
    }

    public function getInsuranceProviderForPatient($patientId): JsonResponse
    {
        $patient = Patient::find($patientId);

        if (!$patient) {
            // Patient not found, handle the error
            return response()->json(['error' => 'Patient not found'], 404);
        }

        // Get the insurance provider associated with the patient
        $insuranceProvider = $patient->insuranceProvider;

        return response()->json($insuranceProvider);
    }
}

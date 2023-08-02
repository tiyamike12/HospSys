<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicalRecords\StoreRequest;
use App\Http\Requests\MedicalRecords\UpdateRequest;
use App\Http\Resources\MedicalRecordResource;
use App\Http\Resources\UserResource;
use App\Models\Billing;
use App\Models\MedicalRecord;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $perPage = 10;

        $medicalRecords = MedicalRecord::with('user.person', 'patient')->orderBy('created_at', 'desc')->paginate($perPage);

        return MedicalRecordResource::collection($medicalRecords);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $medicalRecord = MedicalRecord::create($request->only([
            'patient_id',
            'user_id',
            'medical_notes',
            'diagnoses',
            'prescriptions',
        ]));

        // Add the patient_id to each billing object
        $billingsData = $request->input('billing', []);
        $billingsData = array_map(function ($billing) use ($medicalRecord) {
            return array_merge($billing, ['patient_id' => $medicalRecord->patient_id]);
        }, $billingsData);


        // Attach lab tests to the medical record
        if ($request->has('lab_results') && is_array($request->input('lab_results'))) {
            $medicalRecord->labTests()->attach($request->input('lab_results'));
        }

        // Create billing records and associate them with the medical record
        if (!empty($billingsData)) {
            foreach ($billingsData as $billingData) {
                $billing = $medicalRecord->billings()->create($billingData);
                // You can add any additional logic here for creating billing records
            }
        }
        return response()->json($medicalRecord, 201);

        //return new MedicalRecordResource($medicalRecord);
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicalRecord $medicalRecord): MedicalRecordResource
    {
        return new MedicalRecordResource($medicalRecord);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, MedicalRecord $medicalRecord): JsonResponse
    {
        $patient_id = $medicalRecord->patient_id;

        $medicalRecord->update($request->only([
            'patient_id',
            'user_id',
            'medical_notes',
            'diagnoses',
            'prescriptions',
        ]));

        // Update associated lab test records
        if ($request->has('lab_results')) {
            $medicalRecord->labTests()->sync($request->input('lab_results'));
        }

        // Update associated billing records
//        if ($request->has('billing')) {
//            $billingsData = collect($request->input('billing'))->map(function ($billing) use ($patient_id) {
//                // Add the patient_id to each billing before saving
//                return [
//                    'patient_id' => $patient_id,
//                    'billing_date' => $billing['billing_date'],
//                    'amount' => $billing['amount'],
//                    'payment_status' => $billing['payment_status'],
//                ];
//            });
//
//            $medicalRecord->billings()->delete();
//            $medicalRecord->billings()->createMany($billingsData);
//        }

        return response()->json(['message' => 'Medical record updated successfully'], 200);

        //return new MedicalRecordResource($medicalRecord);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicalRecord $medicalRecord): JsonResponse
    {
        $medicalRecord->delete();
        return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Billing\StoreRequest;
use App\Http\Requests\Billing\UpdateRequest;
use App\Http\Resources\BillingResource;
use App\Models\Billing;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $perPage = 10;

        $billings = Billing::with('patient', 'insuranceProvider')->orderBy('created_at', 'desc')->paginate($perPage);

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

    public function getOverallBillingStatistics(): JsonResponse
    {
        // Get the counts of cash payments and insurance claims
        $cashCount = Billing::whereNull('insurance_provider_id')->count();
        $insuranceCount = Billing::whereNotNull('insurance_provider_id')->count();

        return response()->json([
            'cashCount' => $cashCount,
            'insuranceCount' => $insuranceCount,
        ]);
    }

    public function longPendingClaims(): JsonResponse
    {
        $agingThreshold = env('AGING_THRESHOLD', 70); // Get the value from .env or use 30 as default
        $perPage = 10;

        $today = Carbon::today();
        $thresholdDate = $today->subDays($agingThreshold);

        $longPendingClaims = Billing::where('payment_status', 'pending')
            ->where('billing_date', '<', $thresholdDate)
            ->whereNotNull('insurance_provider_id')
            ->with('patient', 'insuranceProvider')
            ->paginate($perPage);

        return response()->json($longPendingClaims);
    }

    public function billingAnalytics()
    {
        $chartData = DB::table('billings')
            ->selectRaw('MONTH(billing_date) AS month')
            ->selectRaw('SUM(CASE WHEN payment_status = "paid" THEN 1 ELSE 0 END) AS paid')
            ->selectRaw('SUM(CASE WHEN payment_status = "pending" THEN 1 ELSE 0 END) AS pending')
            ->selectRaw('SUM(CASE WHEN payment_status = "rejected" THEN 1 ELSE 0 END) AS rejected')
            ->whereYear('billing_date', date('Y')) // Filter data for the current year
            ->groupBy(DB::raw('MONTH(billing_date)'))
            ->get();

        // Format the data in the desired format for the area chart
        $formattedChartData = [];
        foreach ($chartData as $data) {
            $formattedChartData[] = [
                'month' => $data->month,
                'paid' => $data->paid,
                'pending' => $data->pending,
                'rejected' => $data->rejected,
            ];
        }

        return response()->json($formattedChartData);
    }

    public function getOutstandingBills(): AnonymousResourceCollection
    {
        $perPage = 10;

        $pendings = Billing::where('payment_status', 'pending')
            ->with('patient', 'insuranceProvider')
            ->paginate($perPage);

        return BillingResource::collection($pendings);

//        return response()->json($pendings);
    }

    public function getOutstandingBillingsByPatient($patientId): AnonymousResourceCollection
    {
//        $perPage = 10;

        $outstandingsByPatient = Billing::where('patient_id', $patientId)
            ->where('payment_status', 'pending')
            ->with('patient', 'insuranceProvider')
            ->get();

        return BillingResource::collection($outstandingsByPatient);

//        return response()->json($pendings);
    }

    public function getOutstandingBillingsByProvider($providerId): AnonymousResourceCollection
    {
//        $perPage = 10;

        $outstandingsByProvider = Billing::where('insurance_provider_id', $providerId)
            ->where('payment_status', 'pending')
            ->with('patient', 'insuranceProvider')
            ->get();

        return BillingResource::collection($outstandingsByProvider);

//        return response()->json($pendings);
    }

    public function getPaymentStatusTotals(): JsonResponse
    {
        $totals = [
            'pending' => Billing::totalPendingAmount(),
            'paid' => Billing::totalPaidAmount(),
            'rejected' => Billing::totalRejectedAmount(),
        ];

        return response()->json($totals);
    }



}

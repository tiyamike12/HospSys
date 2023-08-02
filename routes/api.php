<?php

use App\Http\Controllers\api\ActivityLogController;
use App\Http\Controllers\api\AdmissionController;
use App\Http\Controllers\api\AppointmentController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\BedController;
use App\Http\Controllers\api\BillingController;
use App\Http\Controllers\api\DepartmentController;
use App\Http\Controllers\api\DepartmentServiceController;
use App\Http\Controllers\api\InsuranceProviderController;
use App\Http\Controllers\api\InventoryController;
use App\Http\Controllers\api\JobTitleController;
use App\Http\Controllers\api\LabTestController;
use App\Http\Controllers\api\MedicalRecordController;
use App\Http\Controllers\api\OperationTheatreController;
use App\Http\Controllers\api\PatientController;
use App\Http\Controllers\api\PharmacyItemController;
use App\Http\Controllers\api\RoleController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\WardController;
use App\Http\Middleware\RoleBasedAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);

    Route::get('/doctors', [UserController::class, 'getDoctors']);

    Route::patch('/doctor/availability/{doctorId}', [UserController::class, 'setAvailability']);
    Route::get('/doctor/availability/{doctorId}', [UserController::class, 'getAvailability']);

    Route::get('/doctors/available', [AppointmentController::class, 'getAvailableDoctors']);

    Route::apiResource('/users', UserController::class);
    Route::get('/roles', [RoleController::class, 'index']);
    Route::apiResource('/medical-records', MedicalRecordController::class);
    Route::post('/patients/search', [PatientController::class, 'search']);
    Route::get('/patients/insurance/{patientId}', [PatientController::class, 'getInsuranceProviderForPatient']);

    Route::apiResource('/patients', PatientController::class);
    Route::get('/appointments/scheduled/{userId}', [AppointmentController::class, 'getScheduledAppointmentsCount']);
    Route::get('/appointments/completed/{userId}', [AppointmentController::class, 'getCompletedAppointmentsCount']);
    Route::get('/appointments/canceled/{userId}', [AppointmentController::class, 'getCancelledAppointmentsCount']);
    Route::get('/appointments/overall-statistics', [AppointmentController::class, 'getOverallStatistics']);

    Route::get('/appointment/date-range', [AppointmentController::class, 'getAppointmentsByDateRange']);
    Route::apiResource('/appointments', AppointmentController::class);

    Route::get('/billings/overdue-claims', [BillingController::class, 'longPendingClaims']);
    Route::get('/billings/overall-statistics', [BillingController::class, 'getOverallBillingStatistics']);
    Route::get('/billings/chart-analysis', [BillingController::class, 'billingAnalytics']);
    Route::get('/billings/outstanding', [BillingController::class, 'getOutstandingBills']);

    Route::apiResource('/billings', BillingController::class);
    Route::apiResource('/wards', WardController::class);
    Route::apiResource('/pharmacy-items', PharmacyItemController::class);
    Route::apiResource('/beds', BedController::class);
    Route::apiResource('/lab-tests', LabTestController::class);
    Route::apiResource('/operation-theatres', OperationTheatreController::class);
    Route::apiResource('/departments', DepartmentController::class);
    Route::apiResource('/insurance-providers', InsuranceProviderController::class);
    Route::apiResource('/department-services', DepartmentServiceController::class);


    Route::get('/activity-logs', [ActivityLogController::class, 'index']);




});

<?php

use App\Http\Controllers\api\AppointmentController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\BillingController;
use App\Http\Controllers\api\MedicalRecordController;
use App\Http\Controllers\api\PatientController;
use App\Http\Controllers\api\RoleController;
use App\Http\Controllers\api\UserController;
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
    Route::apiResource('/users', UserController::class);
    Route::get('/roles', [RoleController::class, 'index']);
    Route::apiResource('/medical-records', MedicalRecordController::class);
    Route::apiResource('/patients', PatientController::class);
    Route::apiResource('/appointments', AppointmentController::class);
    Route::apiResource('/billings', BillingController::class);
});

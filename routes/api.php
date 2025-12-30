<?php

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

Route::get('/health', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Doctor Appointment API is running',
        'timestamp' => now()->toDateTimeString()
    ]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API Routes for Doctor Appointment System
// These will be implemented with controllers

// Example route structure (to be implemented):
// Route::prefix('v1')->group(function () {
//     // Authentication routes
//     Route::post('/register', [AuthController::class, 'register']);
//     Route::post('/login', [AuthController::class, 'login']);
//     
//     // Protected routes
//     Route::middleware('auth:sanctum')->group(function () {
//         Route::post('/logout', [AuthController::class, 'logout']);
//         
//         // Doctors
//         Route::apiResource('doctors', DoctorController::class);
//         
//         // Patients
//         Route::apiResource('patients', PatientController::class);
//         
//         // Appointments
//         Route::apiResource('appointments', AppointmentController::class);
//         Route::get('appointments/doctor/{doctorId}', [AppointmentController::class, 'getByDoctor']);
//         Route::get('appointments/patient/{patientId}', [AppointmentController::class, 'getByPatient']);
//         
//         // Specializations
//         Route::apiResource('specializations', SpecializationController::class);
//     });
// });

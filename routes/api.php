<?php

use App\Http\Controllers\Api\AuthController;
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

// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Doctor Appointment API is running',
        'timestamp' => now()->toDateTimeString()
    ]);
});

/*
|--------------------------------------------------------------------------
| API Version 1 Routes
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->group(function () {
    
    /*
    |--------------------------------------------------------------------------
    | Admin Authentication Routes (Public)
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Protected Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
        // Auth endpoints
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/logout-all', [AuthController::class, 'logoutAll']);
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/refresh', [AuthController::class, 'refresh']);

        // Admin dashboard routes will be added here
        // Route::get('/dashboard', [DashboardController::class, 'index']);
        
        // Doctors management (admin only)
        // Route::apiResource('doctors', DoctorController::class);
        
        // Patients management (admin only)
        // Route::apiResource('patients', PatientController::class);
        
        // Appointments management (admin only)
        // Route::apiResource('appointments', AppointmentController::class);
        
        // Services management (admin only)
        // Route::apiResource('services', ServiceController::class);
        
        // Blogs management (admin only)
        // Route::apiResource('blogs', BlogController::class);
    });
});

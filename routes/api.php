<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\AppointmentController;
use App\Http\Controllers\Api\Admin\ServiceController;
use App\Http\Controllers\Api\Admin\BlogController;
use App\Http\Controllers\Api\Admin\DoctorController;
use App\Http\Controllers\Api\PublicServiceController;
use App\Http\Controllers\Api\PublicDoctorController;
use App\Http\Controllers\Api\PublicBlogController;
use App\Http\Controllers\Api\PublicAppointmentController;
use App\Http\Controllers\Api\ContactController;
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
    | Public Routes (No Authentication Required)
    |--------------------------------------------------------------------------
    */
    
    // Public Services
    Route::prefix('services')->group(function () {
        Route::get('/', [PublicServiceController::class, 'index']);
        Route::get('/featured', [PublicServiceController::class, 'featured']);
        Route::get('/{slug}', [PublicServiceController::class, 'show']);
    });

    // Public Doctors
    Route::prefix('doctors')->group(function () {
        Route::get('/', [PublicDoctorController::class, 'index']);
        Route::get('/featured', [PublicDoctorController::class, 'featured']);
        Route::get('/specializations', [PublicDoctorController::class, 'specializations']);
        Route::get('/{id}', [PublicDoctorController::class, 'show']);
    });

    // Public Blogs
    Route::prefix('blogs')->group(function () {
        Route::get('/', [PublicBlogController::class, 'index']);
        Route::get('/featured', [PublicBlogController::class, 'featured']);
        Route::get('/categories', [PublicBlogController::class, 'categories']);
        Route::get('/tags', [PublicBlogController::class, 'tags']);
        Route::get('/{slug}', [PublicBlogController::class, 'show']);
        Route::get('/{slug}/related', [PublicBlogController::class, 'related']);
    });

    // Public Appointments (Booking)
    Route::prefix('appointments')->group(function () {
        Route::post('/', [PublicAppointmentController::class, 'store']);
        Route::get('/available-slots', [PublicAppointmentController::class, 'availableSlots']);
        Route::post('/check-status', [PublicAppointmentController::class, 'checkStatus']);
    });

    // Contact Form
    Route::prefix('contact')->group(function () {
        Route::post('/', [ContactController::class, 'submit']);
        Route::get('/info', [ContactController::class, 'info']);
    });

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

        // Appointments management (admin only)
        Route::prefix('appointments')->group(function () {
            Route::get('/statistics', [AppointmentController::class, 'statistics']);
            Route::post('/{id}/approve', [AppointmentController::class, 'approve']);
            Route::post('/{id}/cancel', [AppointmentController::class, 'cancel']);
            Route::post('/{id}/reject', [AppointmentController::class, 'reject']);
            Route::post('/{id}/complete', [AppointmentController::class, 'complete']);
        });
        Route::apiResource('appointments', AppointmentController::class);
        
        // Doctors management (admin only)
        Route::prefix('doctors')->group(function () {
            Route::get('/statistics', [DoctorController::class, 'statistics']);
            Route::get('/specializations', [DoctorController::class, 'specializations']);
            Route::post('/{id}/activate', [DoctorController::class, 'activate']);
            Route::post('/{id}/deactivate', [DoctorController::class, 'deactivate']);
        });
        Route::apiResource('doctors', DoctorController::class);
        
        // Patients management (admin only)
        // Route::apiResource('patients', PatientController::class);
        
        // Services management (admin only)
        Route::prefix('services')->group(function () {
            Route::get('/statistics', [ServiceController::class, 'statistics']);
            Route::post('/reorder', [ServiceController::class, 'reorder']);
            Route::post('/{id}/activate', [ServiceController::class, 'activate']);
            Route::post('/{id}/deactivate', [ServiceController::class, 'deactivate']);
        });
        Route::apiResource('services', ServiceController::class);
        
        // Blogs management (admin only)
        Route::prefix('blogs')->group(function () {
            Route::get('/statistics', [BlogController::class, 'statistics']);
            Route::get('/categories', [BlogController::class, 'categories']);
            Route::get('/tags', [BlogController::class, 'tags']);
            Route::post('/{id}/publish', [BlogController::class, 'publish']);
            Route::post('/{id}/unpublish', [BlogController::class, 'unpublish']);
            Route::post('/{id}/archive', [BlogController::class, 'archive']);
        });
        Route::apiResource('blogs', BlogController::class);
    });
});

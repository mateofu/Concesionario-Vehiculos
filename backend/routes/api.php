<?php

declare(strict_types=1);

use App\Infrastructure\Http\Controllers\AppointmentController;
use App\Infrastructure\Http\Controllers\AuthController;
use App\Infrastructure\Http\Controllers\BlockedPeriodController;
use App\Infrastructure\Http\Controllers\LocationController;
use App\Infrastructure\Http\Controllers\OperatingScheduleController;
use App\Infrastructure\Http\Controllers\OwnerController;
use App\Infrastructure\Http\Controllers\TechnicianController;
use App\Infrastructure\Http\Controllers\VehicleController;
use App\Infrastructure\Http\Controllers\WorkshopController;
use App\Infrastructure\Http\Controllers\WorkStationController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // Auth
    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/me', [AuthController::class, 'me']);

        // Workshops
        Route::get('/workshops', [WorkshopController::class, 'index']);
        Route::post('/workshops', [WorkshopController::class, 'store']);
        Route::get('/workshops/{id}', [WorkshopController::class, 'show']);

        // Locations
        Route::get('/locations', [LocationController::class, 'index']);
        Route::post('/locations', [LocationController::class, 'store']);
        Route::get('/locations/{id}', [LocationController::class, 'show']);

        // Operating Schedules (nested under locations)
        Route::get('/locations/{locationId}/schedules', [OperatingScheduleController::class, 'index']);
        Route::post('/locations/{locationId}/schedules', [OperatingScheduleController::class, 'store']);

        // Blocked Periods (nested under locations)
        Route::get('/locations/{locationId}/blocked-periods', [BlockedPeriodController::class, 'index']);
        Route::post('/locations/{locationId}/blocked-periods', [BlockedPeriodController::class, 'store']);

        // Owners
        Route::get('/owners', [OwnerController::class, 'index']);
        Route::post('/owners', [OwnerController::class, 'store']);
        Route::get('/owners/{id}', [OwnerController::class, 'show']);

        // Vehicles
        Route::get('/vehicles', [VehicleController::class, 'index']);
        Route::post('/vehicles', [VehicleController::class, 'store']);
        Route::get('/vehicles/{id}', [VehicleController::class, 'show']);

        // Technicians
        Route::get('/technicians', [TechnicianController::class, 'index']);
        Route::post('/technicians', [TechnicianController::class, 'store']);
        Route::get('/technicians/{id}', [TechnicianController::class, 'show']);

        // Work Stations
        Route::get('/work-stations', [WorkStationController::class, 'index']);
        Route::post('/work-stations', [WorkStationController::class, 'store']);
        Route::get('/work-stations/{id}', [WorkStationController::class, 'show']);
        Route::post('/work-stations/{workStationId}/technicians', [WorkStationController::class, 'assignTechnician']);

        // Appointments
        Route::get('/appointments', [AppointmentController::class, 'index']);
        Route::post('/appointments', [AppointmentController::class, 'store']);
        Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
        Route::patch('/appointments/{id}/status', [AppointmentController::class, 'updateStatus']);
        Route::delete('/appointments/{id}', [AppointmentController::class, 'cancel']);
    });
});

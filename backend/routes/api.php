<?php

declare(strict_types=1);

use App\Infrastructure\Http\Controllers\AppointmentController;
use App\Infrastructure\Http\Controllers\LocationController;
use App\Infrastructure\Http\Controllers\OwnerController;
use App\Infrastructure\Http\Controllers\TechnicianController;
use App\Infrastructure\Http\Controllers\VehicleController;
use App\Infrastructure\Http\Controllers\WorkshopController;
use App\Infrastructure\Http\Controllers\WorkStationController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::get('/workshops', [WorkshopController::class, 'index']);
    Route::post('/workshops', [WorkshopController::class, 'store']);
    Route::get('/workshops/{id}', [WorkshopController::class, 'show']);

    Route::get('/locations', [LocationController::class, 'index']);
    Route::post('/locations', [LocationController::class, 'store']);
    Route::get('/locations/{id}', [LocationController::class, 'show']);

    Route::post('/owners', [OwnerController::class, 'store']);
    Route::get('/owners/{id}', [OwnerController::class, 'show']);

    Route::post('/vehicles', [VehicleController::class, 'store']);
    Route::get('/vehicles/{id}', [VehicleController::class, 'show']);

    Route::get('/technicians', [TechnicianController::class, 'index']);
    Route::post('/technicians', [TechnicianController::class, 'store']);
    Route::get('/technicians/{id}', [TechnicianController::class, 'show']);

    Route::post('/work-stations', [WorkStationController::class, 'store']);
    Route::get('/work-stations/{id}', [WorkStationController::class, 'show']);
    Route::post('/work-stations/{workStationId}/technicians', [WorkStationController::class, 'assignTechnician']);

    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::post('/appointments', [AppointmentController::class, 'store']);
    Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
    Route::patch('/appointments/{id}/status', [AppointmentController::class, 'updateStatus']);
    Route::delete('/appointments/{id}', [AppointmentController::class, 'cancel']);
});

<?php

declare(strict_types=1);

namespace App\Providers;

use App\Domain\Appointment\IAppointmentRepository;
use App\Domain\Location\ILocationRepository;
use App\Domain\Owner\IOwnerRepository;
use App\Domain\Technician\ITechnicianRepository;
use App\Domain\Vehicle\IVehicleRepository;
use App\Domain\WorkStation\IWorkStationRepository;
use App\Domain\Workshop\IWorkshopRepository;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentAppointmentRepository;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentLocationRepository;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentOwnerRepository;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentTechnicianRepository;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentVehicleRepository;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentWorkshopRepository;
use App\Infrastructure\Persistence\Eloquent\Repositories\EloquentWorkStationRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IWorkshopRepository::class, EloquentWorkshopRepository::class);
        $this->app->bind(ILocationRepository::class, EloquentLocationRepository::class);
        $this->app->bind(IOwnerRepository::class, EloquentOwnerRepository::class);
        $this->app->bind(IVehicleRepository::class, EloquentVehicleRepository::class);
        $this->app->bind(ITechnicianRepository::class, EloquentTechnicianRepository::class);
        $this->app->bind(IWorkStationRepository::class, EloquentWorkStationRepository::class);
        $this->app->bind(IAppointmentRepository::class, EloquentAppointmentRepository::class);
    }

    public function boot(): void {}
}

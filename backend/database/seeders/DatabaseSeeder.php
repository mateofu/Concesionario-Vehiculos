<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Infrastructure\Persistence\Eloquent\Models\AppointmentModel;
use App\Infrastructure\Persistence\Eloquent\Models\LocationModel;
use App\Infrastructure\Persistence\Eloquent\Models\OwnerModel;
use App\Infrastructure\Persistence\Eloquent\Models\TechnicianModel;
use App\Infrastructure\Persistence\Eloquent\Models\VehicleModel;
use App\Infrastructure\Persistence\Eloquent\Models\WorkshopModel;
use App\Infrastructure\Persistence\Eloquent\Models\WorkStationModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Workshop
        $workshop = WorkshopModel::create([
            'id'      => (string) Str::uuid(),
            'name'    => 'Concesionario Central',
            'address' => 'Av. Principal 123, Bogotá',
        ]);

        // Locations
        $location1 = LocationModel::create([
            'id'          => (string) Str::uuid(),
            'workshop_id' => $workshop->id,
            'name'        => 'Sede Norte',
            'address'     => 'Calle 100 #15-30, Bogotá',
        ]);

        $location2 = LocationModel::create([
            'id'          => (string) Str::uuid(),
            'workshop_id' => $workshop->id,
            'name'        => 'Sede Sur',
            'address'     => 'Autopista Sur #45-20, Bogotá',
        ]);

        // WorkStations
        $station1 = WorkStationModel::create([
            'id'          => (string) Str::uuid(),
            'location_id' => $location1->id,
            'name'        => 'Bahía 1',
        ]);

        $station2 = WorkStationModel::create([
            'id'          => (string) Str::uuid(),
            'location_id' => $location1->id,
            'name'        => 'Bahía 2',
        ]);

        $station3 = WorkStationModel::create([
            'id'          => (string) Str::uuid(),
            'location_id' => $location2->id,
            'name'        => 'Bahía 1',
        ]);

        // Technicians
        $tech1 = TechnicianModel::create([
            'id'    => (string) Str::uuid(),
            'name'  => 'Carlos Rodríguez',
            'email' => 'carlos.rodriguez@concesionario.com',
            'phone' => '+57 300 111 2233',
        ]);

        $tech2 = TechnicianModel::create([
            'id'    => (string) Str::uuid(),
            'name'  => 'Andrés Martínez',
            'email' => 'andres.martinez@concesionario.com',
            'phone' => '+57 310 444 5566',
        ]);

        $tech3 = TechnicianModel::create([
            'id'    => (string) Str::uuid(),
            'name'  => 'Laura Gómez',
            'email' => 'laura.gomez@concesionario.com',
            'phone' => '+57 320 777 8899',
        ]);

        // Assign technicians to work stations
        $station1->technicians()->attach($tech1->id);
        $station2->technicians()->attach($tech2->id);
        $station3->technicians()->attach($tech3->id);

        // Owners
        $owner1 = OwnerModel::create([
            'id'    => (string) Str::uuid(),
            'name'  => 'Juan Pérez',
            'email' => 'juan.perez@gmail.com',
            'phone' => '+57 300 123 4567',
        ]);

        $owner2 = OwnerModel::create([
            'id'    => (string) Str::uuid(),
            'name'  => 'María López',
            'email' => 'maria.lopez@gmail.com',
            'phone' => '+57 315 987 6543',
        ]);

        // Vehicles
        $vehicle1 = VehicleModel::create([
            'id'            => (string) Str::uuid(),
            'owner_id'      => $owner1->id,
            'license_plate' => 'ABC123',
            'brand'         => 'Toyota',
            'model'         => 'Corolla',
            'year'          => 2022,
        ]);

        $vehicle2 = VehicleModel::create([
            'id'            => (string) Str::uuid(),
            'owner_id'      => $owner1->id,
            'license_plate' => 'XYZ789',
            'brand'         => 'Mazda',
            'model'         => 'CX-5',
            'year'          => 2023,
        ]);

        $vehicle3 = VehicleModel::create([
            'id'            => (string) Str::uuid(),
            'owner_id'      => $owner2->id,
            'license_plate' => 'DEF456',
            'brand'         => 'Chevrolet',
            'model'         => 'Spark',
            'year'          => 2021,
        ]);

        // Appointments
        AppointmentModel::create([
            'id'              => (string) Str::uuid(),
            'vehicle_id'      => $vehicle1->id,
            'technician_id'   => $tech1->id,
            'work_station_id' => $station1->id,
            'scheduled_at'    => now()->addDays(1)->setTime(9, 0),
            'status'          => 'pending',
            'notes'           => 'Cambio de aceite y revisión general',
        ]);

        AppointmentModel::create([
            'id'              => (string) Str::uuid(),
            'vehicle_id'      => $vehicle2->id,
            'technician_id'   => $tech2->id,
            'work_station_id' => $station2->id,
            'scheduled_at'    => now()->addDays(2)->setTime(10, 30),
            'status'          => 'pending',
            'notes'           => 'Revisión de frenos',
        ]);

        AppointmentModel::create([
            'id'              => (string) Str::uuid(),
            'vehicle_id'      => $vehicle3->id,
            'technician_id'   => $tech3->id,
            'work_station_id' => $station3->id,
            'scheduled_at'    => now()->addDays(3)->setTime(14, 0),
            'status'          => 'pending',
            'notes'           => null,
        ]);
    }
}

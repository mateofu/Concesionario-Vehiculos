<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name'       => 'Admin',
            'email'      => 'admin@taller.co',
            'password'   => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('locations')->insert([
            ['name' => 'Sede Principal', 'address' => 'Calle 100 #15-20',  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sede Norte',     'address' => 'Carrera 30 #45-10', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $sedePrincipal = DB::table('locations')->where('name', 'Sede Principal')->value('id');
        $sedeNorte     = DB::table('locations')->where('name', 'Sede Norte')->value('id');

        DB::table('workshops')->insert([
            ['location_id' => $sedePrincipal, 'name' => 'Taller Mecánica',  'address' => 'Calle 100 #15-20',  'cost_center' => '001', 'created_at' => now(), 'updated_at' => now()],
            ['location_id' => $sedePrincipal, 'name' => 'Taller Latonería', 'address' => 'Calle 100 #15-25',  'cost_center' => '002', 'created_at' => now(), 'updated_at' => now()],
            ['location_id' => $sedeNorte,     'name' => 'Taller Norte',     'address' => 'Carrera 30 #45-10', 'cost_center' => '003', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $tallerMecanica  = DB::table('workshops')->where('name', 'Taller Mecánica')->value('id');
        $tallerLatoneria = DB::table('workshops')->where('name', 'Taller Latonería')->value('id');
        $tallerNorte     = DB::table('workshops')->where('name', 'Taller Norte')->value('id');

        DB::table('work_stations')->insert([
            ['workshop_id' => $tallerMecanica,  'name' => 'Puesto Motor 1',     'station_number' => 1, 'technical_area' => 'Motor',     'created_at' => now(), 'updated_at' => now()],
            ['workshop_id' => $tallerMecanica,  'name' => 'Puesto Eléctrico 1', 'station_number' => 2, 'technical_area' => 'Eléctrico', 'created_at' => now(), 'updated_at' => now()],
            ['workshop_id' => $tallerLatoneria, 'name' => 'Puesto Pintura 1',   'station_number' => 1, 'technical_area' => 'Pintura',   'created_at' => now(), 'updated_at' => now()],
            ['workshop_id' => $tallerNorte,     'name' => 'Puesto General 1',   'station_number' => 1, 'technical_area' => 'General',   'created_at' => now(), 'updated_at' => now()],
        ]);

        $wsId1 = DB::table('work_stations')->where('name', 'Puesto Motor 1')->value('id');
        $wsId2 = DB::table('work_stations')->where('name', 'Puesto Eléctrico 1')->value('id');
        $wsId3 = DB::table('work_stations')->where('name', 'Puesto Pintura 1')->value('id');

        DB::table('technicians')->insert([
            ['name' => 'Carlos Pérez',  'email' => 'carlos@taller.co', 'phone' => '3001234567', 'specialty' => 'Motor',     'is_available' => true,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ana Gómez',     'email' => 'ana@taller.co',    'phone' => '3109876543', 'specialty' => 'Eléctrico', 'is_available' => true,  'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Luis Martínez', 'email' => 'luis@taller.co',   'phone' => '3205551234', 'specialty' => 'Pintura',   'is_available' => false, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $techId1 = DB::table('technicians')->where('email', 'carlos@taller.co')->value('id');
        $techId2 = DB::table('technicians')->where('email', 'ana@taller.co')->value('id');
        $techId3 = DB::table('technicians')->where('email', 'luis@taller.co')->value('id');

        DB::table('work_station_technician')->insert([
            ['work_station_id' => $wsId1, 'technician_id' => $techId1, 'created_at' => now(), 'updated_at' => now()],
            ['work_station_id' => $wsId2, 'technician_id' => $techId2, 'created_at' => now(), 'updated_at' => now()],
            ['work_station_id' => $wsId3, 'technician_id' => $techId3, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('owners')->insert([
            ['first_name' => 'María', 'last_name' => 'Rodríguez', 'document_type' => 'CC', 'document_number' => '12345678', 'email' => 'maria@email.com', 'phone' => '3111234567', 'created_at' => now(), 'updated_at' => now()],
            ['first_name' => 'Juan',  'last_name' => 'Torres',    'document_type' => 'CC', 'document_number' => '87654321', 'email' => 'juan@email.com',  'phone' => '3229876543', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $ownerId1 = DB::table('owners')->where('email', 'maria@email.com')->value('id');
        $ownerId2 = DB::table('owners')->where('email', 'juan@email.com')->value('id');

        DB::table('vehicles')->insert([
            ['owner_id' => $ownerId1, 'license_plate' => 'ABC123', 'brand' => 'Toyota',  'model' => 'Corolla', 'year' => 2020, 'style' => 'Sedán', 'created_at' => now(), 'updated_at' => now()],
            ['owner_id' => $ownerId2, 'license_plate' => 'XYZ789', 'brand' => 'Renault', 'model' => 'Duster',  'year' => 2022, 'style' => 'SUV',   'created_at' => now(), 'updated_at' => now()],
        ]);

        $vehicleId1 = DB::table('vehicles')->where('license_plate', 'ABC123')->value('id');
        $vehicleId2 = DB::table('vehicles')->where('license_plate', 'XYZ789')->value('id');

        foreach ([$sedePrincipal, $sedeNorte] as $locId) {
            foreach (range(1, 7) as $day) {
                DB::table('operating_schedules')->insert([
                    'location_id' => $locId,
                    'day_of_week' => $day,
                    'opens_at'    => '08:00:00',
                    'closes_at'   => '18:00:00',
                    'is_closed'   => $day === 7,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }

        DB::table('blocked_periods')->insert([
            'location_id' => $sedePrincipal,
            'starts_at'   => now()->addMonth()->startOfDay(),
            'ends_at'     => now()->addMonth()->startOfDay()->addDay(),
            'reason'      => 'Día festivo nacional',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        DB::table('appointments')->insert([
            [
                'vehicle_id'       => $vehicleId1,
                'technician_id'    => $techId1,
                'work_station_id'  => $wsId1,
                'scheduled_at'     => now()->addDays(1)->setTime(9, 0),
                'duration_minutes' => 60,
                'status'           => 'programada',
                'notes'            => 'Revisión de motor',
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
            [
                'vehicle_id'       => $vehicleId2,
                'technician_id'    => $techId2,
                'work_station_id'  => $wsId2,
                'scheduled_at'     => now()->addDays(2)->setTime(10, 0),
                'duration_minutes' => 90,
                'status'           => 'confirmada',
                'notes'            => 'Revisión sistema eléctrico',
                'created_at'       => now(),
                'updated_at'       => now(),
            ],
        ]);
    }
}

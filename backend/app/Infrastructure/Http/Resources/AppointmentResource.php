<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this['id'],
            'vehicle_id'       => $this['vehicle_id'],
            'technician_id'    => $this['technician_id'],
            'work_station_id'  => $this['work_station_id'],
            'scheduled_at'     => $this['scheduled_at'],
            'duration_minutes' => $this['duration_minutes'],
            'status'           => $this['status'],
            'notes'            => $this['notes'],
        ];
    }
}

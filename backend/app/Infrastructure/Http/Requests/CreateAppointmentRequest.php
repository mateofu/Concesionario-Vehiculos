<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAppointmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'vehicle_id'       => ['required', 'integer', 'exists:vehicles,id'],
            'technician_id'    => ['required', 'integer', 'exists:technicians,id'],
            'work_station_id'  => ['required', 'integer', 'exists:work_stations,id'],
            'scheduled_at'     => ['required', 'date'],
            'duration_minutes' => ['required', 'integer', 'min:1', 'max:480'],
            'notes'            => ['nullable', 'string', 'max:1000'],
        ];
    }
}

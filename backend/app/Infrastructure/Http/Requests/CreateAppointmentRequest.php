<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAppointmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'vehicle_id'      => ['required', 'uuid'],
            'technician_id'   => ['required', 'uuid'],
            'work_station_id' => ['required', 'uuid'],
            'scheduled_at'    => ['required', 'date'],
            'notes'           => ['nullable', 'string', 'max:1000'],
        ];
    }
}

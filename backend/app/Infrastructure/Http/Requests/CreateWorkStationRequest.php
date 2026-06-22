<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWorkStationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'location_id'    => ['required', 'uuid'],
            'name'           => ['required', 'string', 'max:255'],
            'station_number' => ['required', 'integer', 'min:1'],
            'technical_area' => ['required', 'string', 'max:255'],
        ];
    }
}

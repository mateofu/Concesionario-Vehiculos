<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateVehicleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'owner_id'      => ['required', 'integer', 'exists:owners,id'],
            'license_plate' => ['required', 'string', 'max:20'],
            'brand'         => ['required', 'string', 'max:100'],
            'model'         => ['required', 'string', 'max:100'],
            'year'          => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'style'         => ['required', 'string', 'max:100'],
        ];
    }
}

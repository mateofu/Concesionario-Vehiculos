<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWorkStationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'location_id' => ['required', 'uuid'],
            'name'        => ['required', 'string', 'max:255'],
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWorkshopRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'address'     => ['required', 'string', 'max:500'],
            'cost_center' => ['required', 'string', 'regex:/^\d{3}$/'],
        ];
    }
}

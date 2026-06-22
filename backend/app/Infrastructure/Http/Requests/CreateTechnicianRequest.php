<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTechnicianRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'email'],
            'phone'     => ['required', 'string', 'max:50'],
            'specialty' => ['required', 'string', 'max:255'],
        ];
    }
}

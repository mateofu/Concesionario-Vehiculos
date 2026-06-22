<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetOperatingScheduleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'day_of_week' => ['required', 'integer', 'min:1', 'max:7'],
            'opens_at'    => ['required_unless:is_closed,true', 'nullable', 'date_format:H:i'],
            'closes_at'   => ['required_unless:is_closed,true', 'nullable', 'date_format:H:i', 'after:opens_at'],
            'is_closed'   => ['boolean'],
        ];
    }
}

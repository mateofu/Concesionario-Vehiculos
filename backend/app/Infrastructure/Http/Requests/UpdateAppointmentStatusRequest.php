<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Requests;

use App\Domain\Appointment\ValueObjects\AppointmentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateAppointmentStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['required', new Enum(AppointmentStatus::class)],
        ];
    }
}

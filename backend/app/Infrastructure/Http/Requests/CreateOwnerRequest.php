<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Requests;

use App\Domain\Owner\ValueObjects\DocumentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreateOwnerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name'      => ['required', 'string', 'max:255'],
            'last_name'       => ['required', 'string', 'max:255'],
            'document_type'   => ['required', new Enum(DocumentType::class)],
            'document_number' => ['required', 'string', 'max:50'],
            'email'           => ['required', 'email'],
            'phone'           => ['required', 'string', 'max:50'],
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OwnerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this['id'],
            'first_name'      => $this['first_name'],
            'last_name'       => $this['last_name'],
            'document_type'   => $this['document_type'],
            'document_number' => $this['document_number'],
            'email'           => $this['email'],
            'phone'           => $this['phone'],
        ];
    }
}

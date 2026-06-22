<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TechnicianResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this['id'],
            'name'         => $this['name'],
            'email'        => $this['email'],
            'phone'        => $this['phone'],
            'specialty'    => $this['specialty'],
            'is_available' => $this['is_available'],
        ];
    }
}

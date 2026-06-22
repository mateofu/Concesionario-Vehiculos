<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this['id'],
            'owner_id'      => $this['owner_id'],
            'license_plate' => $this['license_plate'],
            'brand'         => $this['brand'],
            'model'         => $this['model'],
            'year'          => $this['year'],
            'style'         => $this['style'],
        ];
    }
}

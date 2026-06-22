<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkshopResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this['id'],
            'location_id' => $this['location_id'],
            'name'        => $this['name'],
            'address'     => $this['address'],
            'cost_center' => $this['cost_center'],
        ];
    }
}

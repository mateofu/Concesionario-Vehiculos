<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkStationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this['id'],
            'workshop_id'    => $this['workshop_id'],
            'name'           => $this['name'],
            'station_number' => $this['station_number'],
            'technical_area' => $this['technical_area'],
        ];
    }
}

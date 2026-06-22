<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OperatingScheduleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this['id'],
            'location_id' => $this['location_id'],
            'day_of_week' => $this['day_of_week'],
            'opens_at'    => $this['opens_at'],
            'closes_at'   => $this['closes_at'],
            'is_closed'   => $this['is_closed'],
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlockedPeriodResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this['id'],
            'location_id' => $this['location_id'],
            'starts_at'   => $this['starts_at'],
            'ends_at'     => $this['ends_at'],
            'reason'      => $this['reason'],
        ];
    }
}

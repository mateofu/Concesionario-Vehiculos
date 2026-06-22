<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OperatingScheduleModel extends Model
{
    protected $table = 'operating_schedules';

    protected $fillable = ['location_id', 'day_of_week', 'opens_at', 'closes_at', 'is_closed'];

    protected $casts = [
        'day_of_week' => 'integer',
        'is_closed'   => 'boolean',
    ];

    public function location(): BelongsTo
    {
        return $this->belongsTo(LocationModel::class, 'location_id');
    }
}

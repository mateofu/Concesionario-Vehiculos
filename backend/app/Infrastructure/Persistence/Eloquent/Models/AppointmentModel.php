<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppointmentModel extends Model
{
    use HasUuids;

    protected $table = 'appointments';

    protected $fillable = [
        'id',
        'vehicle_id',
        'technician_id',
        'work_station_id',
        'scheduled_at',
        'duration_minutes',
        'status',
        'notes',
    ];

    protected $casts = [
        'scheduled_at'     => 'datetime',
        'duration_minutes' => 'integer',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class, 'vehicle_id');
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(TechnicianModel::class, 'technician_id');
    }

    public function workStation(): BelongsTo
    {
        return $this->belongsTo(WorkStationModel::class, 'work_station_id');
    }
}

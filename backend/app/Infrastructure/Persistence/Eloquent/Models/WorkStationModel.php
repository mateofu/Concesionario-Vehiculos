<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkStationModel extends Model
{
    protected $table = 'work_stations';

    protected $fillable = ['workshop_id', 'name', 'station_number', 'technical_area'];

    protected $casts = ['station_number' => 'integer'];

    public function workshop(): BelongsTo
    {
        return $this->belongsTo(WorkshopModel::class, 'workshop_id');
    }

    public function technicians(): BelongsToMany
    {
        return $this->belongsToMany(
            TechnicianModel::class,
            'work_station_technician',
            'work_station_id',
            'technician_id',
        )->withTimestamps();
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(AppointmentModel::class, 'work_station_id');
    }
}

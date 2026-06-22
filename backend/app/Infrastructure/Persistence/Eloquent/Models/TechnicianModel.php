<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TechnicianModel extends Model
{
    protected $table = 'technicians';

    protected $fillable = ['name', 'email', 'phone', 'specialty', 'is_available'];

    protected $casts = ['is_available' => 'boolean'];

    public function workStations(): BelongsToMany
    {
        return $this->belongsToMany(
            WorkStationModel::class,
            'work_station_technician',
            'technician_id',
            'work_station_id',
        )->withTimestamps();
    }
}

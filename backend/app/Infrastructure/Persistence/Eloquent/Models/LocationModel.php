<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LocationModel extends Model
{
    protected $table = 'locations';

    protected $fillable = [
        'workshop_id',
        'name',
        'address',
    ];

    public function workshop(): BelongsTo
    {
        return $this->belongsTo(WorkshopModel::class, 'workshop_id');
    }

    public function workStations(): HasMany
    {
        return $this->hasMany(WorkStationModel::class, 'location_id');
    }
}

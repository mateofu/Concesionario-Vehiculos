<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkshopModel extends Model
{
    protected $table = 'workshops';

    protected $fillable = ['location_id', 'name', 'address', 'cost_center'];

    public function location(): BelongsTo
    {
        return $this->belongsTo(LocationModel::class, 'location_id');
    }

    public function workStations(): HasMany
    {
        return $this->hasMany(WorkStationModel::class, 'workshop_id');
    }
}

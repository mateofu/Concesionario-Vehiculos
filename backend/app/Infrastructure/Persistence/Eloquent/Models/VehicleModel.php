<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleModel extends Model
{
    protected $table = 'vehicles';

    protected $fillable = ['owner_id', 'license_plate', 'brand', 'model', 'year', 'style'];

    protected $casts = ['year' => 'integer'];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(OwnerModel::class, 'owner_id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(AppointmentModel::class, 'vehicle_id');
    }
}

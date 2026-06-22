<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LocationModel extends Model
{
    protected $table = 'locations';

    protected $fillable = [
        'name',
        'address',
    ];

    public function workshops(): HasMany
    {
        return $this->hasMany(WorkshopModel::class, 'location_id');
    }
}

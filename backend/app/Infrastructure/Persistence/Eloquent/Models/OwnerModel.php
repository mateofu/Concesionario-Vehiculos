<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OwnerModel extends Model
{
    use HasUuids;

    protected $table = 'owners';

    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
    ];

    public function vehicles(): HasMany
    {
        return $this->hasMany(VehicleModel::class, 'owner_id');
    }
}

<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkshopModel extends Model
{
    use HasUuids;

    protected $table = 'workshops';

    protected $fillable = ['id', 'name', 'address', 'cost_center'];

    public function locations(): HasMany
    {
        return $this->hasMany(LocationModel::class, 'workshop_id');
    }
}

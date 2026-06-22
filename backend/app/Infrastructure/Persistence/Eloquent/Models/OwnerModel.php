<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OwnerModel extends Model
{
    protected $table = 'owners';

    protected $fillable = [
        'first_name',
        'last_name',
        'document_type',
        'document_number',
        'email',
        'phone',
    ];

    public function vehicles(): HasMany
    {
        return $this->hasMany(VehicleModel::class, 'owner_id');
    }
}

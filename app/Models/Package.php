<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'package_id',
        'sku_id'
    ];

    public function sku(): HasOne
    {
        return $this->hasOne(Sku::class, 'id', 'package_id');
    }

    public function skus(): HasMany
    {
        return $this->hasMany(Sku::class, 'id', 'sku_id');
    }
}

<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Sku extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'product_id',
        'name'
    ];

    protected $with = ['packageSkus', 'package'];

    protected $appends = ['is_package'];

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class)->withPivot('value');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function packageSkus(): HasManyThrough
    {
        return $this->hasManyThrough(
            self::class,
            Package::class,
            'package_id',
            $this->primaryKey,
            $this->primaryKey,
            'sku_id'
        );
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function getIsPackageAttribute(): bool
    {
        return !! $this->packageSkus->count();
    }
}

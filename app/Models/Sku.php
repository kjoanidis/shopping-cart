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

    protected $with = ['packageSkus'];

    protected $appends = ['is_package'];

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class)->withPivot('value');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function packageSkus(): BelongsToMany
    {
        return $this->belongsToMany(Package::class)->using(PackageSku::class)->withPivot('quantity');
    }

    public function getIsPackageAttribute(): bool
    {
        return !! $this->packageSkus->count();
    }
}

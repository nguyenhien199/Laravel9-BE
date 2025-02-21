<?php

namespace App\Models\Core\Traits;

use Illuminate\Database\Eloquent\Builder;
use Ramsey\Uuid\Uuid as PackageUuid;

/**
 * Trait Uuid
 *
 * @package App\Models\Core\Traits
 */
trait Uuid
{
    /**
     * scope Uuid
     *
     * @param Builder $query
     * @param mixed   $uuid
     * @return mixed
     */
    public function scopeUuid(Builder $query, mixed $uuid): Builder
    {
        return $query->where($this->getUuidName(), $uuid);
    }

    /**
     * get UuidName
     *
     * @return string
     */
    public function getUuidName(): string
    {
        return property_exists($this, 'uuidName') ? $this->uuidName : 'uuid';
    }

    /**
     * Use Laravel bootable traits.
     *
     * @return void
     */
    protected static function bootUuid(): void
    {
        static::creating(function ($model) {
            $model->{$model->getUuidName()} = PackageUuid::uuid4()->toString();
        });
    }
}

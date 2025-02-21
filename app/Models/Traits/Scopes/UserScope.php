<?php

namespace App\Models\Traits\Scopes;

use App\Enums\StatusFlag;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait UserScope
 *
 * @package App\Models\Traits\Scopes
 */
trait UserScope
{
    /**
     * Scope Search Like type by Name.
     *
     * @param Builder $query
     * @param string  $term
     * @return Builder
     */
    public function scopeSearchByName(Builder $query, string $term): Builder
    {
        return $query->where(function ($query) use ($term) {
            $query->Where(TABLE_USER.'.firstname', 'like', '%'.$term.'%')
                ->orWhere(TABLE_USER.'.lastname', 'like', '%'.$term.'%');
        });
    }

    /**
     * Scope Where active status Active.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeOnlyActive(Builder $query): Builder
    {
        return $query->where(TABLE_USER.'.status', '=', StatusFlag::ACTIVE);
    }

    /**
     * Scope where active status Inactive.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeOnlyInactive(Builder $query): Builder
    {
        return $query->where(TABLE_USER.'.status', '=', StatusFlag::INACTIVE);
    }
}

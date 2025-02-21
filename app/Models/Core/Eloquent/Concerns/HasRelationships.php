<?php

namespace App\Models\Core\Eloquent\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Core\Eloquent\Relations\BelongsToManySoft;

trait HasRelationships
{
    /**
     * Instantiate a new BelongsToManySoft relationship.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Database\Eloquent\Model   $parent
     * @param string                                $table
     * @param string                                $foreignPivotKey
     * @param string                                $relatedPivotKey
     * @param string                                $parentKey
     * @param string                                $relatedKey
     * @param string|null                           $relationName
     * @return \App\Models\Core\Eloquent\Relations\BelongsToManySoft
     */
    protected function newBelongsToMany(
        Builder $query,
        Model $parent,
        $table,
        $foreignPivotKey,
        $relatedPivotKey,
        $parentKey,
        $relatedKey,
        $relationName = null
    ): BelongsToManySoft {
        return new BelongsToManySoft($query, $parent, $table, $foreignPivotKey, $relatedPivotKey, $parentKey, $relatedKey, $relationName);
    }
}
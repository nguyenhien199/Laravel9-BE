<?php

namespace App\Models\Core\Eloquent\Relations;

use App\Models\Core\Eloquent\Relations\Concerns\InteractsWithPivotTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class BelongsToManySoft
 * @method self withoutTrashedPivots() Show only non-trashed records
 * @method self withTrashedPivots() Show all records
 * @method self onlyTrashedPivots() Show only trashed records
 * @method int forceDetach(\Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Model|array $ids, bool $touch) Force detach records
 * @method int syncWithForceDetaching(mixed $ids) Sync many-to-many relationship with force detaching
 *
 * @package App\Models\Core\Eloquent\Relations
 */
class BelongsToManySoft extends BelongsToMany
{
    use InteractsWithPivotTable;

    /**
     * Indicates if soft deletes are available on the pivot table.
     *
     * @var bool
     */
    public bool $withSoftDeletes = false;

    /**
     * The custom pivot table column for the deleted_at timestamp.
     *
     * @var string
     */
    protected string $pivotDeletedAt;

    /**
     * Get the name of the "deleted at" column.
     *
     * @return string
     */
    public function deletedAt(): string
    {
        return $this->pivotDeletedAt;
    }

    /**
     * Get the fully qualified deleted at column name.
     *
     * @return string
     */
    public function getQualifiedDeletedAtColumnName(): string
    {
        return $this->getQualifiedColumnName($this->deletedAt());
    }

    /**
     * Get the fully qualified column name.
     *
     * @param string $column
     * @return string
     */
    public function getQualifiedColumnName(string $column): string
    {
        return $this->table.'.'.$column;
    }

    /**
     * @param string $deletedAt
     * @return BelongsToManySoft
     */
    public function withSoftDeletes(string $deletedAt = 'deleted_at'): BelongsToManySoft
    {
        $this->withSoftDeletes = true;

        $this->pivotDeletedAt = $deletedAt;

        $this->macro('withoutTrashedPivots', function () {
            $this->query->withGlobalScope('withoutTrashedPivots', function (Builder $query) {
                $query->whereNull(
                    $this->getQualifiedDeletedAtColumnName()
                );
            })->withoutGlobalScopes(['onlyTrashedPivots']);

            return $this;
        });

        $this->macro('withTrashedPivots', function () {
            $this->query->withoutGlobalScopes(['withoutTrashedPivots', 'onlyTrashedPivots']);

            return $this;
        });

        $this->macro('onlyTrashedPivots', function () {
            $this->query->withGlobalScope('onlyTrashedPivots', function (Builder $query) {
                $query->whereNotNull(
                    $this->getQualifiedDeletedAtColumnName()
                );
            })->withoutGlobalScopes(['withoutTrashedPivots']);

            return $this;
        });

        $this->macro('forceDetach', function ($ids = null, $touch = true) {
            $this->withSoftDeletes = false;

            return tap($this->detach($ids, $touch), function () {
                $this->withSoftDeletes = true;
            });
        });

        $this->macro('syncWithForceDetaching', function ($ids) {
            $this->withSoftDeletes = false;

            return tap($this->sync($ids), function () {
                $this->withSoftDeletes = true;
            });
        });

        return $this->withPivot($this->deletedAt())->withoutTrashedPivots();
    }

    /**
     * Set the join clause for the relation query.
     *
     * @param \Illuminate\Database\Eloquent\Builder|null $query
     * @return $this
     */
    protected function performJoin($query = null): static
    {
        $query = $query ?: $this->query;

        // We need to join to the intermediate table on the related model's primary
        // key column with the intermediate table's foreign key for the related
        // model instance. Then we can set the "where" for the parent models.
        $baseTable = $this->related->getTable();

        $key = $baseTable.'.'.$this->relatedKey;

        $query->join($this->table, $key, '=', $this->getQualifiedRelatedPivotKeyName());

        $query->when($this->withSoftDeletes, function (Builder $query) {
            $query->whereNull($this->getQualifiedDeletedAtColumnName());
        });

        return $this;
    }
}
<?php

namespace App\Http\Resources\Core;

use App\Constants\ModelConst;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Spatie\LaravelData\Data;

/**
 * Class BaseResource
 *
 * @package App\Http\Resources\Core
 */
abstract class BaseResource extends Data
{
    protected static string $_collectionClass = Collectable\DataCollection::class;

    protected static string $_paginatedCollectionClass = Collectable\PaginatedDataCollection::class;

    protected static string $_cursorPaginatedCollectionClass = Collectable\CursorPaginatedDataCollection::class;

    /**
     * Create resource from Model.
     *
     * @param Model $model <p>Model instance</p>
     * @return static
     */
    public static function fromModel(Model $model): static
    {
        $data = [];
        $classVars = get_class_vars(static::class);
        foreach ($classVars as $field => $value) {
            if (
                !method_exists($model, $field)
                ||
                (method_exists($model, $field) && is_a($model->{$field}(), Relation::class) && $model->relationLoaded($field))
            ) {
                $data = array_merge($data, static::formatModelData($model, $field));
            }
        }

        return static::from($data);
    }

    /**
     * Format Model field data.
     *
     * @param Model $model <p>Model instance.</p>
     * @param string $field <p>Model property.</p>
     * @return array
     */
    protected static function formatModelData(Model $model, string $field): array
    {
        if (in_array($field, [ModelConst::CREATED_AT, ModelConst::UPDATED_AT, ModelConst::DELETED_AT]) && !empty($model->{$field})) {
            return [$field => carbon($model->{$field})];
        }
        else {
            return [$field => $model->{$field}];
        }
    }
}

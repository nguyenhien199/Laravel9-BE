<?php

namespace App\Http\Resources\Core\Collectable\Traits;

use App\Http\Resources\Core\Transformers\DataCollectableTransformer;
use Spatie\LaravelData\Support\Wrapping\WrapExecutionType;

/**
 * Trait BaseDataCollectable
 * @template TKey of array-key
 * @template TValue
 *
 * @package App\Http\Resources\Core\Collectable\Traits
 */
trait BaseDataCollectable
{
    /**
     * @return array<array|TValue>
     */
    public function transform(
        bool $transformValues = true,
        WrapExecutionType $wrapExecutionType = WrapExecutionType::Disabled,
        bool $mapPropertyNames = true,
    ): array {
        $transformer = new DataCollectableTransformer(
            $this->dataClass,
            $transformValues,
            $wrapExecutionType,
            $mapPropertyNames,
            $this->getPartialTrees(),
            $this->items,
            $this->getWrap(),
        );

        return $transformer->transform();
    }
}

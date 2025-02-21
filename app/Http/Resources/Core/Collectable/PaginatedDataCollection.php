<?php

namespace App\Http\Resources\Core\Collectable;

/**
 * Class PaginatedDataCollection
 * @template TKey of array-key
 * @template TValue
 *
 * @implements \Spatie\LaravelData\Contracts\DataCollectable<TKey, TValue>
 * @package App\Http\Resources\Core\Collectable
 */
class PaginatedDataCollection extends \Spatie\LaravelData\PaginatedDataCollection
{
    /** @use Traits\BaseDataCollectable<TKey, TValue> */
    use Traits\BaseDataCollectable;
}

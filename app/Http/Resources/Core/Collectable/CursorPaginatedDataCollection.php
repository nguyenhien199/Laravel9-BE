<?php

namespace App\Http\Resources\Core\Collectable;

/**
 * Class CursorPaginatedDataCollection
 * @template TKey of array-key
 * @template TValue
 *
 * @implements \Spatie\LaravelData\Contracts\DataCollectable<TKey, TValue>
 * @package App\Http\Resources\Core\Collectable
 */
class CursorPaginatedDataCollection extends \Spatie\LaravelData\CursorPaginatedDataCollection
{
    /** @use Traits\BaseDataCollectable<TKey, TValue> */
    use Traits\BaseDataCollectable;
}

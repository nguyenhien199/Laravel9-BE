<?php

namespace App\Http\Resources\Core\Collectable;

/**
 * Class DataCollection
 * @template TKey of array-key
 * @template TValue
 *
 * @implements \ArrayAccess<TKey, TValue>
 * @implements \Spatie\LaravelData\Contracts\DataCollectable<TKey, TValue>
 * @package App\Http\Resources\Core\Collectable
 */
class DataCollection extends \Spatie\LaravelData\DataCollection
{
    /** @use Traits\BaseDataCollectable<TKey, TValue> */
    use Traits\BaseDataCollectable;
}

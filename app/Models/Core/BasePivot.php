<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Relations\Concerns\AsPivot;

/**
 * Class BasePivot
 * Set default Model value
 *
 * @package App\Models\Core
 */
abstract class BasePivot extends BaseModel
{
    use AsPivot;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['*'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        //
    ];
}

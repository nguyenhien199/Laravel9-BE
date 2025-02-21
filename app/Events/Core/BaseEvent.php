<?php

namespace App\Events\Core;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class BaseEvent
 *
 * @package App\Events\Core
 */
abstract class BaseEvent
{
    use Dispatchable,
        SerializesModels;
}

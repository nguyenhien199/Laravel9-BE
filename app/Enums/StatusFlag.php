<?php

namespace App\Enums;

use BenSampo\Enum\Attributes\Description;

/**
 * Class StatusFlag
 * @method static static ACTIVE()
 * @method static static INACTIVE()
 *
 * @package App\Enums
 */
#[Description('List of available status flags.')]
final class StatusFlag extends Core\BaseEnum
{
    #[Description('Active.')]
    const ACTIVE = 1;

    #[Description('Inactive.')]
    const INACTIVE = 0;
}

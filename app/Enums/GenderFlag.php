<?php

namespace App\Enums;

use BenSampo\Enum\Attributes\Description;

/**
 * Class GenderFlag
 * @method static static OTHER()
 * @method static static MALE()
 * @method static static FEMALE()
 *
 * @package App\Enums
 */
#[Description('List of available Gender flags.')]
final class GenderFlag extends Core\BaseEnum
{
    #[Description('Other')]
    public const OTHER = 0;

    #[Description('Male')]
    public const MALE = 1;

    #[Description('Female')]
    public const FEMALE = 2;
}

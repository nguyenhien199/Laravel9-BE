<?php

use App\Enums\GenderFlag;
use App\Enums\StatusFlag;

return [

    StatusFlag::class => [
        StatusFlag::ACTIVE   => 'Active',
        StatusFlag::INACTIVE => 'Inactive',
    ],

    GenderFlag::class => [
        GenderFlag::OTHER  => 'Other',
        GenderFlag::MALE   => 'Male',
        GenderFlag::FEMALE => 'Female',
    ],

];

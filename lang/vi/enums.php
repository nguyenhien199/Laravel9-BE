<?php

use App\Enums\GenderFlag;
use App\Enums\StatusFlag;

return [

    StatusFlag::class => [
        StatusFlag::ACTIVE   => 'Đang hoạt động',
        StatusFlag::INACTIVE => 'Không hoạt động',
    ],

    GenderFlag::class => [
        GenderFlag::OTHER  => 'Khác',
        GenderFlag::MALE   => 'Nam',
        GenderFlag::FEMALE => 'Nữ',
    ],

];

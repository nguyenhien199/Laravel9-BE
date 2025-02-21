<?php

use App\Enums\GenderFlag;
use App\Enums\StatusFlag;

return [

    StatusFlag::class => [
        StatusFlag::ACTIVE   => '有効',
        StatusFlag::INACTIVE => '無効',
    ],

    GenderFlag::class => [
        GenderFlag::OTHER  => 'その他',
        GenderFlag::MALE   => '男性',
        GenderFlag::FEMALE => '女性',
    ],

];

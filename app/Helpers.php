<?php

namespace App;


class Helpers
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const GENERAL_STATUSES = [
        self::STATUS_ACTIVE => 'Đang kích hoạt',
        self::STATUS_INACTIVE => 'Chưa kích hoạt',
    ];
}

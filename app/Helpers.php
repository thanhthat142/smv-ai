<?php

namespace App;


use App\Models\Category;

class Helpers
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const GENERAL_STATUSES = [
        self::STATUS_ACTIVE => 'Đang kích hoạt',
        self::STATUS_INACTIVE => 'Chưa kích hoạt',
    ];

    public static function getCategories()
    {
        return Category::whereNull('parent_id')->where('status', self::STATUS_ACTIVE)->get();
    }
}

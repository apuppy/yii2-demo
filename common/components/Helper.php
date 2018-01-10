<?php

namespace common\components;

class Helper
{

    /**
     * 验证是否是手机号
     * @param $mobile
     * @return false|int
     */
    public static function validate_mobile($mobile)
    {
        return preg_match("/\d{11}$/", $mobile);
    }

}
<?php

namespace common\components;

use Yii;
use yii\helpers\VarDumper;

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

    /**
     * 将变量打印到文件
     * @param $var
     */
    public static function log_to_file($var)
    {
        $log_file = Yii::getAlias('@runtime/logs/file_log.log');
        $str_var = VarDumper::export($var);
        $str_var .= "\n";
        file_put_contents($log_file,$str_var,FILE_APPEND);
    }

}
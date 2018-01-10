<?php

namespace frontend\controllers;

use common\components\Helper;
use common\controllers\frontend\BaseController;
use Yii;

class TestController extends BaseController
{
    public function actionIndex()
    {
        $mobile = '13501607059';
        //yii component configration usage
        $helper = Yii::$app->helper;
        $validation_ret = $helper::validate_mobile($mobile);
        var_dump($validation_ret);
        //origin namespace usage
        $validation_ret_origin = Helper::validate_mobile($mobile);
        var_dump($validation_ret_origin);
    }

}
<?php

namespace frontend\controllers;

use app\models\District;
use common\components\Helper;
use common\controllers\frontend\BaseController;
use Elasticsearch\ClientBuilder;
use Yii;
use yii\helpers\VarDumper;

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

    public function actionObjectMerge()
    {
        $top3 = District::find()->orderBy(['id' => 'desc'])->limit(3)->indexBy('id')->all();
        $end3 = District::find()->orderBy(['id' => 'desc'])->limit(2)->indexBy('id')->all();
        $combination = array_merge($top3,$end3);
        // $combination = $top3 + $end3;
        var_dump($combination);
    }

    public function actionElasticSearch()
    {
        $client = ClientBuilder::create()->build();
        var_dump($client);
    }

}
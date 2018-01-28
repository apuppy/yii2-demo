<?php

namespace frontend\controllers;

use app\models\District;
use app\models\People;
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

    /**
     * 测试AR的afterSave事件
     */
    public function actionAfterSave()
    {
        $people = new People();
        $people->name = 'lala';
        $people->sex = 0;
        $people->age = 24;
        $people->save(0);
    }

    /**
     * 测试AR的afterFind事件
     */
    public function actionAfterFind()
    {
        People::find()->one();
    }

    /**
     * 测试AR的afterDelete事件
     */
    public function actionAfterDelete()
    {
        People::find()->one()->delete();
    }

}
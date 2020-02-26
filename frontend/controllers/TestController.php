<?php

namespace frontend\controllers;

use app\models\District;
use app\models\People;
use common\components\Helper;
use common\components\RedisLock;
use common\controllers\frontend\BaseController;
use Elasticsearch\ClientBuilder;
use Sentry;
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

    /**
     * redis锁简单实现
     */
    public function actionRedis_lock()
    {
        $config = [
            'host' => 'localhost',
            'port' => 6379,
            'index' => 0,
            'auth' => '',
            'timeout' => 1,
            'reserved' => NULL,
            'retry_interval' => 100,
        ];

        // redis lock instance
        $oRedisLock = new RedisLock($config);
        // redis lock key
        $key = 'test_lock';

        // get redis lock
        $is_lock = $oRedisLock->lock($key, 10);
        if($is_lock){
            // get lock success
            // do something here
            // unlock
            $oRedisLock->unlock($key);
        } else {
            // limit request frequence
        }
    }

    /**
     * 测试\common\logging\RabbitmqTarget
     */
    public function actionLog()
    {
        $message = "write some message to test rabbitmq-server log target";
        Yii::info($message);
        exit;
    }

    /**
     * 测试sentry
     * @throws \Exception
     */
    public function actionSentry()
    {
        Sentry\init(['dsn' => 'http://0558f208d2c44cc8ad22c4b342e7f422@sentry.yuzhua-dev.com/3' ]);
        throw new \Exception("yii2 framework error to sentry!");
    }

}
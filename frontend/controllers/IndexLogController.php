<?php

namespace frontend\controllers;

use common\models\IndexLog;
use yii\filters\Cors;
use yii\web\Controller;

/**
 * IndexLogController implements the CRUD actions for IndexLog model.
 */
class IndexLogController extends Controller
{

    function behaviors()
    {
        $behaviors = parent::behaviors();
        return array_merge($behaviors, [
            'corsFilter' => [
                'class' => Cors::class,
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'OPTIONS'],
                    'Access-Control-Allow-Credentials' => false,
                    'Access-Control-Allow-Headers' => ['authorization', 'X-Requested-With', 'content-type', 'Content-Type', 'Accept', 'Referer', 'X-Token']
                ],
            ],
        ]);
    }

    /**
     * Lists all IndexLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $list = IndexLog::find()->limit(20)->asArray()->all();
        return $list;
    }

}

<?php

namespace frontend\controllers;

use common\models\IndexLog;
use Yii;
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
        $request = Yii::$app->request;
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 20);
        $index_name = $request->get('index_name', '');
        $level = $request->get('level', '');
        $message = $request->get('message', '');
        $parameters = $request->get('parameters', '');

        $query = IndexLog::find();
        $where = ['AND'];
        if ($index_name) {
            $where[] = ['LIKE', 'index_name', $index_name];
        }
        if ($level) {
            $where[] = ['=', 'level', $level];
        }
        if ($message) {
            $where[] = ['LIKE', 'message', $message];
        }
        if ($parameters) {
            $where[] = ['LIKE', 'params', $parameters];
        }
        if (count($where) > 1) {
            $query->where($where);
        }

        $total = $query->count();
        $list = $query->offset(($page - 1) * $limit)->limit($limit)->orderBy(['id' => SORT_DESC, 'created_at' => SORT_DESC])->asArray()->all();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'data' => [
                'items' => $list,
                'total' => (int)$total
            ],
            'code' => 20000,
            'message' => 'OK'
        ];
    }

}

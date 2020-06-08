<?php

namespace backend\controllers;

use common\jobs\DownloadJob;
use Yii;
use backend\models\BlogSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * TestController implements the CRUD actions for Blog model.
 */
class TestController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            //附加行为
            'as access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['queue', 'index', 'redis'],
                        'allow' => true,
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * Lists all Blog models.
     * @return mixed
     * @throws \yii\web\ForbiddenHttpException
     */
    public function actionIndex()
    {
        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionQueue()
    {
        /** @var $queue \yii\queue\Queue */
        $queue = Yii::$app->queue;
        $queue->push(new DownloadJob([
            'url' => 'https://p.ssl.qhimg.com/t01061e2fec7bf1b0ad.png',
            'file' => '/Users/hongde/image.png',
        ]));
        echo 'done';
    }

    public function actionRedis()
    {
        /** @var $redis \yii\redis\Connection */
        $redis = Yii::$app->redis;
        $redis->set('yii-redis', 'yii-redis-val');
        echo $redis->get('yii-redis');
    }

}

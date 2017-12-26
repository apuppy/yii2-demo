<?php

namespace frontend\controllers;

use common\controllers\frontend\BaseController;
use frontend\services\CityService;
use yii\helpers\VarDumper;

class CityController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionList()
    {
        $counties = CityService::find_counties_by_city_name('汉');
        VarDumper::dump($counties);
    }

}

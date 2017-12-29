<?php

namespace frontend\controllers;

use common\controllers\frontend\BaseController;
use frontend\services\CityService;

class CityController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionList()
    {
        $counties = CityService::find_counties_by_city_name('汉');
        return $this->render('city-list', [
            'city_list' => $counties,
        ]);

    }

}

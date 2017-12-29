<?php

namespace backend\controllers;

use common\controllers\backend\BaseAdminController;

class DashboardController extends BaseAdminController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}

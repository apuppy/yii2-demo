<?php

namespace frontend\services;

use app\models\District;
use common\services\CommonService;

class CityService extends CommonService
{

    /**
     * 根据市名搜索其下县级行政区
     * @param $city_name
     * @return array|static[]
     */
    public static function find_counties_by_city_name($city_name)
    {
        $city_id = District::find()->where(['like','name',$city_name])->select('id')->scalar();
        if($city_id){
            $county = District::findAll(['parent_id' => $city_id]);
        } else {
            $county = [];
        }
        return $county;
    }

}
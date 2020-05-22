<?php

namespace common\services;


use stdClass;

class CommonService
{

    public static function greeting($greeting)
    {
        return 'Hi there, ' . $greeting;
    }

    public static function array_to_object($array)
    {
        $object = new stdClass();
        foreach ($array as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }

}
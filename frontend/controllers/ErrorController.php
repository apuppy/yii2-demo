<?php

namespace frontend\controllers;

use yii\web\Controller;

class ErrorController extends Controller
{

    public function actionError()
    {
        $exception = \Yii::$app->errorHandler->exception;
        $exception_info = [
            'URI' => $_SERVER['REQUEST_URI'],
            'request_data' => http_build_query($_REQUEST),
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'message' => $exception->getMessage(),
            'trace_string' => $exception->getTraceAsString()
        ];
        $exception_string = "URI : {$exception_info['URI']} request_data : {$exception_info['request_data']} code : {$exception_info['code']} file : {$exception_info['file']} line : {$exception_info['line']} message : {$exception_info['message']} trace_string : {$exception_info['trace_string']}";
        echo($exception_string);
    }

}
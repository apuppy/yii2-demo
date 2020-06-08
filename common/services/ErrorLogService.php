<?php

namespace common\services;

use common\models\ErrorLog;
use Exception;
use yii\base\ErrorException;

class ErrorLogService
{

    public static function record($error_info)
    {
        /**
         * 'id' => 'ID',
         * 'module' => 'Module',
         * 'level' => 'Level',
         * 'code' => 'Code',
         * 'message' => 'Message',
         * 'file' => 'File',
         * 'trace' => 'Trace',
         * 'created_date' => 'Created Date',
         * 'created_at' => 'Created At',
         * */
        $model = new ErrorLog();
        $model->setAttributes($error_info);
        return $model->save(0);
    }


    /**
     * @param $error Exception
     * @return void
     */
    public static function record_queue_error($error)
    {
        if ($error instanceof ErrorException) {
            $error_info = [
                'module' => 'queue',
                'level' => 'error',
                'code' => $error->getCode(),
                'message' => $error->getMessage(),
                'file' => $error->getFile(),
                'line' => $error->getLine(),
                'trace' => $error->getTraceAsString(),
                'created_date' => date('Y-m-d'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            static::record($error_info);
        }
    }

}
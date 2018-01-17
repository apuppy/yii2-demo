<?php

namespace common\components;

use app\models\SqlLog;
use Yii;
use yii\log\Target;

class SqlLogTarget extends Target
{

    public function export()
    {
        array_pop($this->messages);//去除冗余信息
        $app = Yii::$app->id;
        $log_file = Yii::getAlias('@runtime/logs/sql.log');
        $request_uri = !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $messages = $this->messages;
        foreach ($messages as $message) {
            $sql_list[] = $message[0];
            $files = array_column($message[4], 'file');
            $file_list = [];
            foreach ($files as $file) {
                if (!in_array($file, $file_list)) {
                    $file_list[] = $file;
                }
            }
        }
        $sqls = implode(PHP_EOL, $sql_list);
        $files = var_export($file_list, true);
        $str_messages = var_export($messages, true);

        // to DB
        $sql_log = new SqlLog();
        $sql_log->app = $app;
        $sql_log->request_uri = $request_uri;
        $sql_log->trace_file = $files;
        $sql_log->trace_sql = $sqls;
        $sql_log->extra = $str_messages;
        $sql_log->save(0);

        //to file
        file_put_contents($log_file, $str_messages, FILE_APPEND);
    }

}
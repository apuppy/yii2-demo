<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sql_log".
 *
 * @property string $id
 * @property string $app
 * @property string $request_uri
 * @property string $trace_file
 * @property string $trace_sql
 * @property string $extra
 * @property string $created_time
 */
class SqlLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sql_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['extra'], 'string'],
            [['created_time'], 'safe'],
            [['app'], 'string', 'max' => 32],
            [['request_uri'], 'string', 'max' => 500],
            [['trace_file'], 'string', 'max' => 2000],
            [['trace_sql'], 'string', 'max' => 10000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'app' => 'App',
            'request_uri' => 'Request Uri',
            'trace_file' => 'Trace File',
            'trace_sql' => 'Trace Sql',
            'extra' => 'Extra',
            'created_time' => 'Created Time',
        ];
    }
}

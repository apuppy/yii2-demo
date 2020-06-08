<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "error_log".
 *
 * @property int $id
 * @property string $module application module
 * @property string $level error or exeception level
 * @property int $code error code
 * @property string $message error message
 * @property string $file related code file
 * @property string|null $trace trace
 * @property string|null $created_date created date
 * @property string $created_at
 */
class ErrorLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'error_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'integer'],
            [['trace'], 'string'],
            [['created_date', 'created_at'], 'safe'],
            [['module'], 'string', 'max' => 20],
            [['level'], 'string', 'max' => 10],
            [['message'], 'string', 'max' => 300],
            [['file'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module' => 'Module',
            'level' => 'Level',
            'code' => 'Code',
            'message' => 'Message',
            'file' => 'File',
            'trace' => 'Trace',
            'created_date' => 'Created Date',
            'created_at' => 'Created At',
        ];
    }
}

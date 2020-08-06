<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "index_log".
 *
 * @property int $id
 * @property int $type 日志类型 全量索引 增量索引
 * @property string $index_name 索引名
 * @property string $level 日志级别
 * @property string $message 错误日志消息
 * @property string|null $params 调用参数
 * @property string|null $full_response 返回结果
 * @property string|null $created_at
 */
class IndexLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'index_log';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     * @throws \yii\base\InvalidConfigException
     */
    public static function getDb()
    {
        return Yii::$app->get('search_engine_db');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['params', 'full_response'], 'string'],
            [['created_at'], 'safe'],
            [['index_name'], 'string', 'max' => 20],
            [['level'], 'string', 'max' => 10],
            [['message'], 'string', 'max' => 600],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'index_name' => 'Index Name',
            'level' => 'Level',
            'message' => 'Message',
            'params' => 'Params',
            'full_response' => 'Full Response',
            'created_at' => 'Created At',
        ];
    }
}

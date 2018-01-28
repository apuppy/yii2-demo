<?php

namespace app\models;

use common\components\Helper;
use Yii;

/**
 * This is the model class for table "people".
 *
 * @property int $id
 * @property string $name 名字
 * @property int $sex 性别 0:女 1:男
 * @property int $age 年龄
 * @property string $created_time 创建时间
 */
class People extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'people';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex', 'age'], 'integer'],
            [['created_time'], 'safe'],
            [['name'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'sex' => 'Sex',
            'age' => 'Age',
            'created_time' => 'Created Time',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $log_var = [
            'action' => 'afterSave',
            'vars' => $this->toArray(),
            'insert' => $insert, // true when insert ; false when update
            'changed_attr' => $changedAttributes
        ];
        Helper::log_to_file($log_var);
    }

    public function afterFind()
    {
        parent::afterFind();
        $log_var = [
            'action' => 'afterFind',
            'vars' => $this->toArray()
        ];
        Helper::log_to_file($log_var);
    }

    public function afterDelete()
    {
        parent::afterDelete();
        $log_var = [
            'action' => 'afterDelete',
            'vars' => $this->toArray()
        ];
        Helper::log_to_file($log_var);
    }
}

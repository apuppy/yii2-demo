<?php

namespace common\DB\Demo;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name 姓名
 * @property int $sex 性别 0:未知 1：男 2：女
 * @property int $age 年龄
 * @property string $birthday 生日
 * @property string $tel 电话号码
 * @property string $created_at
 * @property string $updated_at
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex', 'age'], 'integer'],
            [['birthday', 'created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 16],
            [['tel'], 'string', 'max' => 15],
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
            'birthday' => 'Birthday',
            'tel' => 'Tel',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}

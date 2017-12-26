<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "district".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property string $initial
 * @property string $initials
 * @property string $pinyin
 * @property string $suffix
 * @property string $code
 * @property integer $order
 */
class District extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'district';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'order'], 'integer'],
            [['name'], 'string', 'max' => 270],
            [['initial'], 'string', 'max' => 3],
            [['initials', 'code'], 'string', 'max' => 30],
            [['pinyin'], 'string', 'max' => 600],
            [['suffix'], 'string', 'max' => 15],
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
            'parent_id' => 'Parent ID',
            'initial' => 'Initial',
            'initials' => 'Initials',
            'pinyin' => 'Pinyin',
            'suffix' => 'Suffix',
            'code' => 'Code',
            'order' => 'Order',
        ];
    }
}

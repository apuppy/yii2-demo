<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id 栏目ID
 * @property string $name 栏目名
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
}


$a = [
    'class' => 'yii\grid\ActionColumn',
    'template' => '{update}  {delete}',
    'header' => '操作',
    'buttons' => [
        'update' => function ($url, $model, $key) {
            return Html::a("信息", $url, [
                'title' => '栏目信息',
                // btn-update 目标class
                'class' => 'btn btn-default btn-update',
                'data-toggle' => 'modal',
                'data-target' => '#operate-modal',
            ]);
        },
        'delete' => function ($url, $model, $key) {
            return Html::a('删除', $url, [
                'title' => '删除',
                'class' => 'btn btn-default',
                'data' => [
                    'confirm' => '确定要删除么?',
                    'method' => 'post',
                ],
            ]);
        },
    ],
];